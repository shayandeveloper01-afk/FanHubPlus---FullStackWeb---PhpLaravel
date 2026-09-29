<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use App\Support\EventArtwork;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $admin  = User::where('is_admin', true)->first();
        $music  = Category::where('slug', 'music')->first();
        $gaming = Category::where('slug', 'gaming')->first();
        $anime  = Category::where('slug', 'anime')->first();
        $film   = Category::where('slug', 'film')->first();

        $events = [
            [
                'title' => 'FanHub Karachi Community Night',
                'description' => 'A Karachi anime and gaming community meetup for fans, creators, and live entertainment.',
                'venue_name' => 'Karachi Arts Council', 'address' => 'M.R. Kiyani Road',
                'city' => 'Karachi', 'country' => 'Pakistan', 'latitude' => 24.8607, 'longitude' => 67.0011,
                'start_datetime' => now()->addDays(18)->setTime(18, 0), 'end_datetime' => now()->addDays(18)->setTime(22, 0),
                'ticket_link' => null, 'category' => $gaming,
            ],
            [
                'title' => 'Dubai Fan Expo', 'description' => 'A weekend celebrating anime, gaming, film, and fan culture.',
                'venue_name' => 'Dubai World Trade Centre', 'address' => 'Sheikh Zayed Road',
                'city' => 'Dubai', 'country' => 'United Arab Emirates', 'latitude' => 25.2285, 'longitude' => 55.2867,
                'start_datetime' => now()->addDays(40)->setTime(10, 0), 'end_datetime' => now()->addDays(41)->setTime(20, 0),
                'ticket_link' => null, 'category' => $anime,
            ],
            // Upcoming
            [
                'title'          => 'Tokyo Anime Festival 2025',
                'description'    => 'The largest anime convention in Asia, featuring exclusive premieres, cosplay contests, and guest panels.',
                'venue_name'     => 'Tokyo Big Sight',
                'address'        => '3-11-1 Ariake, Koto City',
                'city'           => 'Tokyo',
                'country'        => 'Japan',
                'latitude'       => 35.6298,
                'longitude'      => 139.7956,
                'start_datetime' => now()->addDays(30)->setTime(10, 0),
                'end_datetime'   => now()->addDays(32)->setTime(20, 0),
                'ticket_link'    => 'https://example.com/tickets/tokyo-anime-fest',
                'category'       => $anime,
            ],
            [
                'title'          => 'Coachella Valley Music & Arts Festival',
                'description'    => 'Iconic outdoor music festival in the California desert. Three days of music, art, and culture.',
                'venue_name'     => 'Empire Polo Club',
                'address'        => '81800 Avenue 51',
                'city'           => 'Indio',
                'country'        => 'United States',
                'latitude'       => 33.6823,
                'longitude'      => -116.2380,
                'start_datetime' => now()->addDays(45)->setTime(12, 0),
                'end_datetime'   => now()->addDays(47)->setTime(23, 59),
                'ticket_link'    => 'https://example.com/tickets/coachella',
                'category'       => $music,
            ],
            [
                'title'          => 'EVO 2025 — Fighting Game Championship',
                'description'    => 'The world\'s premier fighting game tournament. Street Fighter, Tekken, Mortal Kombat and more.',
                'venue_name'     => 'Mandalay Bay Convention Center',
                'address'        => '3950 S Las Vegas Blvd',
                'city'           => 'Las Vegas',
                'country'        => 'United States',
                'latitude'       => 36.0916,
                'longitude'      => -115.1760,
                'start_datetime' => now()->addDays(60)->setTime(9, 0),
                'end_datetime'   => now()->addDays(62)->setTime(22, 0),
                'ticket_link'    => 'https://example.com/tickets/evo-2025',
                'category'       => $gaming,
            ],
            [
                'title'          => 'London Film Festival — Opening Night',
                'description'    => 'BFI London Film Festival opening gala screening with red carpet and Q&A.',
                'venue_name'     => 'Royal Festival Hall',
                'address'        => 'Belvedere Rd, South Bank',
                'city'           => 'London',
                'country'        => 'United Kingdom',
                'latitude'       => 51.5045,
                'longitude'      => -0.1160,
                'start_datetime' => now()->addDays(20)->setTime(19, 30),
                'end_datetime'   => now()->addDays(20)->setTime(23, 0),
                'ticket_link'    => 'https://example.com/tickets/lff',
                'category'       => $film,
            ],
            [
                'title'          => 'Gamescom 2025',
                'description'    => 'Europe\'s largest gaming trade show. Hands-on demos, world premieres, and cosplay.',
                'venue_name'     => 'Koelnmesse',
                'address'        => 'Messeplatz 1',
                'city'           => 'Cologne',
                'country'        => 'Germany',
                'latitude'       => 50.9463,
                'longitude'      => 6.9820,
                'start_datetime' => now()->addDays(90)->setTime(9, 0),
                'end_datetime'   => now()->addDays(94)->setTime(18, 0),
                'ticket_link'    => 'https://example.com/tickets/gamescom',
                'category'       => $gaming,
            ],
            [
                'title'          => 'Glastonbury Festival 2025',
                'description'    => 'The world-famous performing arts festival on Worthy Farm, Somerset.',
                'venue_name'     => 'Worthy Farm',
                'address'        => 'Pilton, Shepton Mallet',
                'city'           => 'Somerset',
                'country'        => 'United Kingdom',
                'latitude'       => 51.1537,
                'longitude'      => -2.5897,
                'start_datetime' => now()->addDays(55)->setTime(11, 0),
                'end_datetime'   => now()->addDays(59)->setTime(23, 59),
                'ticket_link'    => null,
                'category'       => $music,
            ],
            // Past events
            [
                'title'          => 'Anime Expo 2024 — Los Angeles',
                'description'    => 'North America\'s largest anime convention. Panels, screenings, and exclusive merchandise.',
                'venue_name'     => 'Los Angeles Convention Center',
                'address'        => '1201 S Figueroa St',
                'city'           => 'Los Angeles',
                'country'        => 'United States',
                'latitude'       => 34.0407,
                'longitude'      => -118.2698,
                'start_datetime' => now()->subDays(60)->setTime(10, 0),
                'end_datetime'   => now()->subDays(57)->setTime(20, 0),
                'ticket_link'    => null,
                'category'       => $anime,
            ],
            [
                'title'          => 'The Game Awards 2024',
                'description'    => 'Annual celebration of the best in video games, with world premiere announcements.',
                'venue_name'     => 'Peacock Theater',
                'address'        => '1111 S Figueroa St',
                'city'           => 'Los Angeles',
                'country'        => 'United States',
                'latitude'       => 34.0430,
                'longitude'      => -118.2673,
                'start_datetime' => now()->subDays(30)->setTime(20, 0),
                'end_datetime'   => now()->subDays(30)->setTime(23, 30),
                'ticket_link'    => null,
                'category'       => $gaming,
            ],
        ];

        foreach ($events as $data) {
            $slug = Str::slug($data['title']);
            $existing = Event::where('slug', $slug)->first();
            if ($existing) {
                $updates = [];
                if (! $existing->country && ! empty($data['country'])) {
                    $updates['country'] = $data['country'];
                }
                if ($data['title'] === 'FanHub Karachi Community Night' && $gaming && $existing->category_id !== $gaming->id) $updates['category_id'] = $gaming->id;
                if ($data['title'] === 'FanHub Karachi Community Night' && str_contains((string) $existing->description, 'community gathering for fans')) $updates['description'] = $data['description'];
                if ($updates) $existing->update($updates);
                continue;
            }

            Event::create([
                'user_id'        => $admin->id,
                'category_id'    => $data['category']?->id,
                'title'          => $data['title'],
                'description'    => $data['description'],
                'venue_name'     => $data['venue_name'],
                'address'        => $data['address'],
                'city'           => $data['city'],
                'country'        => $data['country'],
                'latitude'       => $data['latitude'],
                'longitude'      => $data['longitude'],
                'start_datetime' => $data['start_datetime'],
                'end_datetime'   => $data['end_datetime'],
                'ticket_link'    => $data['ticket_link'],
            ]);
        }

        // Refresh only generated demo artwork. Images uploaded by an admin are preserved.
        foreach (Event::withTrashed()->with('category')->get() as $event) {
            $path = 'catalog-artwork/event/'.$event->id.'-'.Str::slug($event->title).'.svg';
            $isGenerated = str_starts_with((string) $event->cover_image, 'catalog-artwork/event/');
            if ($event->cover_image && ! $isGenerated && (filter_var($event->cover_image, FILTER_VALIDATE_URL) || Storage::disk('public')->exists($event->cover_image))) {
                continue;
            }

            Storage::disk('public')->put($path, EventArtwork::svg($event->title, $event->category?->name ?? 'Fan Event', $event->city, $event->id));
            if ($event->cover_image !== $path) {
                $event->forceFill(['cover_image' => $path])->saveQuietly();
            }
        }
    }
}
