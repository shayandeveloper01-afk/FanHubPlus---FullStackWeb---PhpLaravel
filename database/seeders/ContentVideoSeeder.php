<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Content;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use RuntimeException;

class ContentVideoSeeder extends Seeder
{
    /**
     * Curated, category-specific sample video catalog. Each image is YouTube's
     * thumbnail for the very same video ID used by trailer_url.
     *
     * Existing working catalog IDs are reused where they already represent
     * the topic; titles/slugs are stable so running this seeder is idempotent.
     */
    private const CATALOG = [
        'anime' => ['Anime', 'anime', 'Adventure', [
            ['Demon Slayer — Infinity Castle Preview', 'x7uLutVRBfI'],
            ['Jujutsu Kaisen — Culling Game Trailer', 'MePL_vS-G9Q'],
            ['Vinland Saga — Season Two Trailer', 'Ph50sNkApVM'],
            ['Frieren — Beyond Journey’s End Preview', 'tR8YH0G67Rk'],
            ['New Saga — Official Anime Trailer', 'BaomnapVQ-0'],
            ['Chainsaw Man: Reze Arc — Official Anime Film Trailer', 'LjAgmxL5xkw'],
            ['My Hero Academia: Final Season — Official Trailer', 'fXbY97v2k4s'],
            ['Attack on Titan: The Final Chapters — Special Trailer', 'M_OauHnAFc8'],
            ['Crunchyroll Spring 2026 — Anime Season Preview', '7Wc6ugY3meg'],
            ['Gachiakuta — Official Trailer', '3UkmWacjR7Q'],
        ]],
        'comics' => ['Comics', 'other', 'Superhero', [
            ['Marvel Ultimate Endgame — Comic Event Trailer', 'j1YHKBraABA'],
            ['The Ultimates #1 — Marvel Comics Trailer', 'jXvLMDSk8LY'],
            ['Ultimate Spider-Man — Official Marvel Comics Trailer', 'jKuLR5KCiY0'],
            ['Ultimate Black Panther #1 — Official Marvel Comics Trailer', '3PJA_uXj_Zk'],
            ['Ultimate Invasion #1 — Official Marvel Comics Trailer', 'dagPKfcYHn4'],
        ]],
        'manga' => ['Manga', 'anime', 'Manga Preview', [
            ['Jujutsu Kaisen Modulo — Manga Promotional Video', 'plJgNCcUS_I', 'https://d28hgpri8am2if.cloudfront.net/book_images/onix/cvr9781974771455/jujutsu-kaisen-modulo-vol-1-9781974771455_hr.jpg'],
            ['Sword of the Demon Hunter: Kijin Gentosho — Manga Promotional Video', 'l-0oLbHzfWw', 'https://images3.penguinrandomhouse.com/smedia/9781685793333'],
            ['Assassin’s Creed Dynasty — Official Manga Trailer', 'tFSwg8Qv2sg'],
            ['Kingdom — Official Manga Trailer', 'dfOe-VRQijY'],
            ['Hunter x Hunter — Official Manga Trailer', 'ZeXQulzYbqE'],
            ['Chainsaw Man, Vol. 12 — Official Manga Trailer', '__F7YFMYxAY'],
            ['Chainsaw Man, Vol. 1 — Official Manga Trailer', 'tVG_sBhNcr0'],
            ['Spy x Family, Vol. 1 — Official Manga Trailer', 'g1F16L66Y_Q'],
            ['Dandadan, Vol. 1 — Official Manga Trailer', 'tRJIGlh1ILY'],
            ['Death Note Short Stories — Official Manga Trailer', 'Rax3IuHnF4M'],
        ]],
        'movies' => ['Movies', 'movie', 'Fantasy & Action', [
            ['Avengers: Doomsday — Official Teaser', '399Ez7WHK5s'],
            ['Avengers: Endgame — Official Trailer', 'TcMBFSGVi1c'],
            ['Avengers: Infinity War — Official Trailer', '6ZfuNTqbHE8'],
            ['The Marvels — Official Trailer', '1myF4CtgoLw'],
            ['Spider-Man: No Way Home — Official Trailer', 'JfVOs4VSpmA'],
            ['Dune: Part Two — Official Trailer', 'Way9Dexny3w'],
            ['Barbie — Official Trailer', 'pBk4NYhWNMM'],
            ['Deadpool & Wolverine — Official Trailer', '73_1biulkYk'],
            ['The Batman — Official Trailer', 'mqqft2x_Aa4'],
        ]],
        'tv-series' => ['TV Series', 'series', 'Drama & Fantasy', [
            ['The Eternaut — Official Series Trailer', 'TqT4fDQQqCc'],
            ['YOU — Official Series Trailer', 'v99ooSjCVhg'],
            ['Superestar — Official Series Trailer', 'h75xrfq-SBE', 'https://pics.filmaffinity.com/superestar-231903360-large.jpg'],
            ['Olympo — Official Series Trailer', 'bqDwi4i8NRo', 'https://static.tvmaze.com/uploads/images/original_untouched/572/1431039.jpg'],
            ['Roosters — Official Series Trailer', 'eOREb9wDcvk'],
            ['Wednesday — Official Series Trailer', 'Di310WS8zLk'],
            ['The Last of Us — Official Series Trailer', 'uLtkt8BonwM'],
            ['House of the Dragon — Official Series Trailer', 'DotnJ7tTA34'],
            ['Arcane: Season Two — Official Trailer', 'hsffPST-x1k'],
            ['Severance: Season Two — Official Trailer', '_UXKlYvLGJY'],
        ]],
        'gaming' => ['Gaming', 'game', 'Gaming', [
            ['Elden Ring — Shadow of the Erdtree Gameplay', 'JugxpebuS_E'],
            ['Black Myth: Wukong — First Gameplay', '7eS7schhJ8k'],
            ['Civilization VII — Gameplay Overview', 'kK_JrrP9m2U'],
            ['League of Legends Worlds — Championship Highlights', 'rZHrffKAc6k'],
            ['Elden Ring Nightreign — Reveal Gameplay Trailer', 'Djtsw5k_DNc'],
            ['Grand Theft Auto VI — Official Trailer 2', 'VQRLujxTm3c'],
            ['The Legend of Zelda: Tears of the Kingdom — Official Trailer', '2SNF4M_v7wc'],
            ['Super Mario Bros. Wonder — Official Overview', 'G0m_uNaSres'],
            ['Elden Ring — Official Launch Trailer', 'AKXiKBnzpBQ'],
            ['Cyberpunk 2077 — Official Cinematic Trailer', '8X2kIfS6fb8'],
        ]],
        'cosplay' => ['Cosplay', 'other', 'Male Cosplay Builds', [
            ['Odin Makes — War Machine Cosplay Helmet', 'WuheOkYkzlw'],
            ['Odin Makes — Gundam Cosplay Helmet Build', 'gO3yICj9gvY'],
            ['Odin Makes — Full Gundam Cosplay Body Armor', '_6iaDJ9lFV8'],
            ['Odin Makes — Full Gundam Suit Cosplay Build', 'zXpVTeJNJZA'],
            ['Odin Makes — Lando Calrissian Cosplay Helmet', 'PzmPViZbrHQ'],
            ['Odin Makes — Mechagodzilla Cosplay Hands', '5f_o0Hih-0o'],
            ['Odin Makes — Infinity Gauntlet Cosplay Prop', 'lwmzq81ezic'],
            ['Odin Makes — Thor Mjolnir Cosplay Prop', '4JcNl1PeY0M'],
            ['Odin Makes — Black Panther Cosplay Mask', 'y3FK9TB1UM8'],
            ['Odin Makes — Mechagodzilla Cosplay Arms', 'Q-pZeePU9i0'],
        ]],
        'events' => ['Events', 'other', 'Fandom Events', [
            ['Netflix Tudum 2025 — Global Fan Event Highlights', 'lcCx2oLavbc'],
            ['Netflix Tudum 2025 — Official Event Trailer', 'jdgVdMolHlo'],
            ['Anime Expo — Zenless Zone Zero Stage Highlights', 'p6Mq6Fx0uds'],
            ['PAX West — Convention Highlights', 'msqLAWgNXWo'],
            ['Jump Festa — Official Event Broadcast', 'D0lHvj8pNxs'],
            ['Gamescom Opening Night Live 2025 — Full Showcase', 'HVC_dBNUZGc'],
            ['AnimeJapan Kickoff 2025 — Stage Preview', 'fqTpYnPLLzg'],
            ['AnimeJapan 2025 — Bandai Namco Stage', 'Ff0wywnfG5o'],
            ['AnimeJapan 2025 — Isekai Channel Stage', 'aX_vzFv0Wm8'],
            ['AnimeJapan 2025 — Gunpla Special Stage', 'fkPJTWf55Zk'],
        ]],
    ];

    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@fanhubplus.com')->first()
            ?? User::query()->where('is_admin', true)->first()
            ?? User::query()->first();

        if (! $admin) {
            throw new RuntimeException('Content videos need an existing user. Run AdminUserSeeder first.');
        }

        foreach (self::CATALOG as $slug => [$categoryName, $type, $genre, $videos]) {
            $category = Category::query()->where('slug', $slug)->first();

            if (! $category) {
                $this->command?->warn("Skipped {$categoryName}: category '{$slug}' does not exist. Run CategorySeeder first.");
                continue;
            }

            // Replace the old convention and anime cosplay cards with male-led,
            // family-friendly cosplay build videos. Updating in place keeps
            // bookmarks and other references attached to the existing cards.
            if ($slug === 'cosplay') {
                $oldCosplayVideoIds = [
                    'ElXU1VeUoOk', '_2K_8zkBTM4', 'MMnVKvXtB14', 'qCEhhD-yDvc',
                    'NL-2ZdsVw24', 'cEvIivpSUgI', '0ODZmov4FUA', 'tsuYXmvrug4',
                    '2xYOO8u0lN4', 'MnXoNcdGspA', '7OaIEOtjLA8',
                ];

                $existingCosplayCards = Content::query()
                    ->where('category_id', $category->id)
                    ->whereIn('trailer_url', collect($oldCosplayVideoIds)
                        ->map(fn (string $id) => "https://www.youtube.com/watch?v={$id}")
                        ->all())
                    ->orderBy('id')
                    ->get();

                foreach ($existingCosplayCards as $index => $oldCard) {
                    $replacement = $videos[$index] ?? null;
                    if (! $replacement) {
                        continue;
                    }

                    [$title, $videoId] = $replacement;
                    $oldCard->update([
                        'title' => $title,
                        'slug' => Str::slug($title),
                        'trailer_url' => "https://www.youtube.com/watch?v={$videoId}",
                        'thumbnail' => "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg",
                    ]);
                }
            }

            // These used to be filed under Comics despite being movie trailers.
            // Remove the old category assignments so the page only shows comic
            // publishing/story promos from the curated Comics catalog.
            if ($slug === 'comics') {
                Content::query()
                    ->where('category_id', $category->id)
                    ->whereIn('trailer_url', [
                        'https://www.youtube.com/watch?v=shW9i6k8cB0',
                        'https://www.youtube.com/watch?v=vS3_72Gb-bI',
                        'https://www.youtube.com/watch?v=hebWYacbdvc',
                        'https://www.youtube.com/watch?v=xy8aJw1vYHo',
                        'https://www.youtube.com/watch?v=fIHH5-HVS9o',
                    ])
                    ->delete();
            }

            // Repair the older Blue Lock sample that used an unavailable video ID.
            // Update its existing row so bookmarks and other relations keep working.
            if ($slug === 'anime') {
                Content::query()
                    ->where('category_id', $category->id)
                    ->where('trailer_url', 'https://www.youtube.com/watch?v=e5Q6Nw7y1Jg')
                    ->first()
                    ?->update([
                        'title' => 'Gachiakuta — Official Trailer',
                        'trailer_url' => 'https://www.youtube.com/watch?v=3UkmWacjR7Q',
                        'thumbnail' => 'https://img.youtube.com/vi/3UkmWacjR7Q/hqdefault.jpg',
                    ]);
            }

            foreach ($videos as $video) {
                [$title, $videoId] = $video;
                $stableTitle = $title;
                $videoUrl = "https://www.youtube.com/watch?v={$videoId}";
                $thumbnailUrl = $video[2] ?? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";

                // An existing entry already supplies this exact video in this
                // category; don't create a second card for the same trailer.
                $existingVideo = Content::query()
                    ->where('category_id', $category->id)
                    ->where('trailer_url', $videoUrl)
                    ->first();
                if ($existingVideo) {
                    $existingVideo->update([
                        'user_id' => $admin->id,
                        'title' => $stableTitle,
                        'body' => "A curated {$genre} feature for {$categoryName} fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.",
                        'status' => 'published',
                        'genre' => $genre,
                        'year' => now()->year,
                        'type' => $type,
                        'thumbnail' => $thumbnailUrl,
                    ]);
                    continue;
                }

                Content::query()->updateOrCreate(
                    ['slug' => Str::slug($stableTitle)],
                    [
                        'user_id' => $admin->id,
                        'category_id' => $category->id,
                        'title' => $stableTitle,
                        'body' => "A curated {$genre} feature for {$categoryName} fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.",
                        'status' => 'published',
                        'genre' => $genre,
                        'year' => now()->year,
                        'type' => $type,
                        'views_count' => 0,
                        'thumbnail' => $thumbnailUrl,
                        'trailer_url' => $videoUrl,
                    ]
                );
            }

            // Remove only this seeder's obsolete sample cards. This clears old
            // cross-category/demo trailers without touching user-created content.
            $currentVideoUrls = collect($videos)
                ->map(fn (array $video) => "https://www.youtube.com/watch?v={$video[1]}")
                ->all();

            Content::query()
                ->where('category_id', $category->id)
                ->where('title', 'like', "{$categoryName} Spotlight:%")
                ->whereNotIn('trailer_url', $currentVideoUrls)
                ->delete();
        }
    }
}
