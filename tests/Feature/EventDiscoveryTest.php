<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\EventRsvp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EventDiscoveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_filter_endpoint_combines_city_category_location_and_dates(): void
    {
        $owner = User::factory()->create();
        $category = $this->category('Meetups');
        $match = $this->event($owner, $category, [
            'title' => 'Fan Meetup', 'city' => 'Lahore', 'venue_name' => 'Central Hall',
            'address' => 'Main Boulevard', 'latitude' => 31.5204, 'longitude' => 74.3587,
            'start_datetime' => now()->addDays(10)->setTime(18, 0),
        ]);
        $this->event($owner, $category, [
            'title' => 'Another Meetup', 'city' => 'Karachi', 'venue_name' => 'Central Hall',
            'start_datetime' => now()->addDays(10)->setTime(18, 0),
        ]);
        $this->event($owner, $category, [
            'title' => 'Later Meetup', 'city' => 'Lahore', 'venue_name' => 'Central Hall',
            'start_datetime' => now()->addDays(30)->setTime(18, 0),
        ]);

        $this->getJson(route('events.filter', [
            'city' => 'Lahore', 'category' => $category->id, 'q' => 'Boulevard',
            'date_from' => now()->addDays(9)->toDateString(),
            'date_to' => now()->addDays(11)->toDateString(),
        ]))
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('mapEvents.0.id', $match->id)
            ->assertJsonPath('mapEvents.0.category', 'Meetups')
            ->assertJsonPath('calendarEvents.0.url', route('events.show', $match))
            ->assertJsonPath('cardEvents.0.city', 'Lahore');
    }

    public function test_filter_endpoint_rejects_an_inverted_date_range_and_invalid_coordinates(): void
    {
        $this->getJson(route('events.filter', [
            'date_from' => '2026-10-20', 'date_to' => '2026-10-19',
        ]))->assertUnprocessable()->assertJsonValidationErrors('date_to');

        $this->getJson(route('events.filter', ['lat' => 91, 'lng' => 0]))
            ->assertUnprocessable()->assertJsonValidationErrors('lat');
    }

    public function test_radius_endpoint_returns_only_real_events_inside_radius_and_other_filters(): void
    {
        $owner = User::factory()->create();
        $category = $this->category('Conventions');
        $near = $this->event($owner, $category, [
            'title' => 'Nearby Convention', 'city' => 'Metro', 'venue_name' => 'Hall A',
            'latitude' => 0.1, 'longitude' => 0,
        ]);
        $this->event($owner, $category, [
            'title' => 'Distant Convention', 'city' => 'Metro', 'venue_name' => 'Hall B',
            'latitude' => 2, 'longitude' => 0,
        ]);

        $this->getJson(route('events.nearby', [
            'lat' => 0, 'lng' => 0, 'radius' => 25, 'category' => $category->id,
            'city' => 'Metro', 'q' => 'Hall',
        ]))
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('mapEvents.0.id', $near->id)
            ->assertJsonPath('cardEvents.0.distance_km', 11.1);
    }

    public function test_event_can_be_created_updated_and_deleted_by_its_owner_only(): void
    {
        Http::fake();
        Storage::fake('public');
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $category = $this->category('Screenings');

        $this->actingAs($owner)->post(route('events.store'), [
            'title' => 'Premiere Night', 'category_id' => $category->id,
            'venue_name' => 'Grand Cinema', 'address' => '1 Main Road', 'city' => 'Lahore',
            'start_datetime' => now()->addDays(14)->format('Y-m-d\TH:i'),
            'latitude' => '0', 'longitude' => '0',
            'ticket_link' => 'https://tickets.example.test/premiere',
            'description' => 'Community screening night.',
            'cover_image' => UploadedFile::fake()->image('premiere.jpg'),
        ])->assertRedirect(route('events.index'))->assertSessionHas('success');

        $event = Event::where('title', 'Premiere Night')->firstOrFail();
        $this->assertSame($owner->id, $event->user_id);
        $this->assertSame(0.0, (float) $event->latitude);
        $this->assertDatabaseHas('events', ['id' => $event->id, 'ticket_link' => 'https://tickets.example.test/premiere']);
        Storage::disk('public')->assertExists($event->cover_image);
        $this->get(route('events.index'))->assertOk()->assertSee('Premiere Night');

        $this->actingAs($other)->patch(route('events.update', $event), [
            'title' => 'Unauthorized edit', 'category_id' => $category->id,
            'venue_name' => 'Grand Cinema', 'city' => 'Lahore',
            'start_datetime' => now()->addDays(15)->format('Y-m-d\TH:i'),
            'latitude' => '0', 'longitude' => '0',
        ])->assertForbidden();

        $this->actingAs($owner)->patch(route('events.update', $event), [
            'title' => 'Updated Premiere', 'category_id' => $category->id,
            'venue_name' => 'Grand Cinema', 'city' => 'Lahore',
            'start_datetime' => now()->addDays(15)->format('Y-m-d\TH:i'),
            'latitude' => '0', 'longitude' => '0',
        ])->assertRedirect(route('events.show', $event->fresh()));
        $this->assertDatabaseHas('events', ['id' => $event->id, 'title' => 'Updated Premiere']);

        EventRsvp::create(['event_id' => $event->id, 'user_id' => $other->id, 'status' => 'going']);
        $this->actingAs($owner)->delete(route('events.destroy', $event->fresh()))
            ->assertRedirect(route('events.index'));
        $this->assertSoftDeleted('events', ['id' => $event->id]);
        $this->assertDatabaseHas('event_rsvps', ['event_id' => $event->id, 'user_id' => $other->id]);
        Storage::disk('public')->assertExists($event->cover_image);

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->post(route('admin.events.restore', $event->id))->assertRedirect();
        $this->assertDatabaseHas('events', ['id' => $event->id, 'deleted_at' => null]);
        Storage::disk('public')->assertExists($event->cover_image);
    }

    private function category(string $name): Category
    {
        return Category::create([
            'name' => $name,
            'slug' => str($name)->slug(),
            'status' => 'active',
        ]);
    }

    private function event(User $owner, Category $category, array $attributes = []): Event
    {
        return Event::create(array_merge([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'title' => 'Test Event',
            'venue_name' => 'Test Venue',
            'city' => 'Test City',
            'start_datetime' => now()->addDays(7),
        ], $attributes));
    }
}
