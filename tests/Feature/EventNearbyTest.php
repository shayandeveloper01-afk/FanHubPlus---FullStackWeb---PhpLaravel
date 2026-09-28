<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventNearbyTest extends TestCase
{
    use RefreshDatabase;

    public function test_nearby_scope_calculates_and_filters_event_distances(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Nearby Category',
            'slug' => 'nearby-category',
            'status' => 'active',
        ]);

        $nearby = Event::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Nearby Event',
            'venue_name' => 'Nearby Venue',
            'city' => 'Nearby City',
            'latitude' => 0,
            'longitude' => 0,
            'start_datetime' => now()->addDay(),
        ]);

        $farAway = Event::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Far Away Event',
            'venue_name' => 'Far Venue',
            'city' => 'Far City',
            'latitude' => 1,
            'longitude' => 0,
            'start_datetime' => now()->addDay(),
        ]);

        $result = Event::nearby(0, 0, 25)->first();

        $this->assertNotNull($result);
        $this->assertSame($nearby->id, $result->id);
        $this->assertEqualsWithDelta(0.0, $nearby->distanceFrom(0, 0), 0.01);
        $this->assertFalse(Event::nearby(0, 0, 25)->pluck('id')->contains($farAway->id));
    }
}
