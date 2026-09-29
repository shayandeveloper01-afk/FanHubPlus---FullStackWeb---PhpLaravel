<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use App\Support\EventArtwork;
use Database\Seeders\EventSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventArtworkTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_events_get_unique_relevant_local_artwork_without_duplicate_rows(): void
    {
        Storage::fake('public');
        User::factory()->create(['is_admin' => true]);
        foreach (['music', 'gaming', 'anime', 'film'] as $slug) {
            Category::create(['name' => ucfirst($slug), 'slug' => $slug, 'status' => 'active']);
        }

        $seeder = app(EventSeeder::class);
        $seeder->run();
        $initialCount = Event::count();
        $seeder->run();

        $events = Event::with('category')->get();
        $this->assertSame($initialCount, $events->count());
        $paths = $events->pluck('cover_image');
        $this->assertSame($events->count(), $paths->unique()->count());

        foreach ($events as $event) {
            Storage::disk('public')->assertExists($event->cover_image);
            $svg = Storage::disk('public')->get($event->cover_image);
            $this->assertStringContainsString($event->title, html_entity_decode($svg));
            $this->assertStringContainsString($event->city, html_entity_decode($svg));
        }
    }

    public function test_admin_can_upload_and_replace_event_cover_while_edit_without_upload_keeps_it(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Anime', 'slug' => 'anime', 'status' => 'active']);
        $this->actingAs($admin)->post(route('admin.events.store'), [
            'title' => 'Tokyo Anime Showcase', 'category_id' => $category->id,
            'venue_name' => 'Tokyo Big Sight', 'country' => 'Japan', 'city' => 'Tokyo',
            'start_datetime' => now()->addDays(12)->format('Y-m-d\TH:i'),
            'cover_image' => UploadedFile::fake()->image('tokyo.webp'),
        ])->assertRedirect(route('admin.events.index'));

        $event = Event::where('title', 'Tokyo Anime Showcase')->firstOrFail();
        $firstPath = $event->cover_image;
        Storage::disk('public')->assertExists($firstPath);

        $this->put(route('admin.events.update', $event), [
            'title' => $event->title, 'category_id' => $category->id,
            'venue_name' => 'Tokyo Big Sight', 'country' => 'Japan', 'city' => 'Tokyo',
            'start_datetime' => now()->addDays(12)->format('Y-m-d\TH:i'),
        ])->assertRedirect(route('admin.events.index'));
        $this->assertSame($firstPath, $event->fresh()->cover_image);

        $this->put(route('admin.events.update', $event), [
            'title' => $event->title, 'category_id' => $category->id,
            'venue_name' => 'Tokyo Big Sight', 'country' => 'Japan', 'city' => 'Tokyo',
            'start_datetime' => now()->addDays(12)->format('Y-m-d\TH:i'),
            'cover_image' => UploadedFile::fake()->image('replacement.jpg'),
        ])->assertRedirect(route('admin.events.index'));
        $updatedPath = $event->fresh()->cover_image;
        $this->assertNotSame($firstPath, $updatedPath);
        Storage::disk('public')->assertExists($updatedPath);
        Storage::disk('public')->assertMissing($firstPath);
    }

    public function test_event_art_is_wide_and_distinct_for_different_event_topics(): void
    {
        $tokyo = EventArtwork::svg('Tokyo Anime Festival 2025', 'Anime', 'Tokyo', 1);
        $coachella = EventArtwork::svg('Coachella Valley Music & Arts Festival', 'Music', 'Indio', 2);

        $this->assertStringContainsString('viewBox="0 0 960 540"', $tokyo);
        $this->assertNotSame($tokyo, $coachella);
        $this->assertStringContainsString('>Tokyo</text>', $tokyo);
        $this->assertStringContainsString('>Indio</text>', $coachella);
    }
}
