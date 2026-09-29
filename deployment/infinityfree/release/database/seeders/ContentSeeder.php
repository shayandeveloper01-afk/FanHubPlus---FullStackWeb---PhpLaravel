<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Content;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@fanhubplus.com')->first();

        // Map category slug => id
        $cat = Category::pluck('id', 'slug');

        $items = [
            // ── Music ────────────────────────────────────────────────────────
            [
                'category' => 'music', 'type' => 'music', 'genre' => 'Pop',
                'title' => 'Taylor Swift — The Eras Tour Review',
                'body'  => 'An epic journey through every era of Taylor Swift\'s career. The Eras Tour is a once-in-a-generation concert experience spanning 44 songs across 3.5 hours.',
                'year'  => 2023, 'views_count' => 4800, 'status' => 'published',
            ],
            [
                'category' => 'music', 'type' => 'music', 'genre' => 'Hip-Hop',
                'title' => 'Kendrick Lamar — GNX Album Deep Dive',
                'body'  => 'Kendrick\'s latest project GNX arrives as a surprise drop, showcasing his West Coast roots with sharp lyricism and cinematic production.',
                'year'  => 2024, 'views_count' => 3200, 'status' => 'published',
            ],
            [
                'category' => 'music', 'type' => 'music', 'genre' => 'K-Pop',
                'title' => 'BLACKPINK World Tour: Born Pink Highlights',
                'body'  => 'BLACKPINK\'s Born Pink world tour broke records across Asia, Europe, and North America. Here\'s a full breakdown of the best moments.',
                'year'  => 2023, 'views_count' => 2900, 'status' => 'published',
            ],
            [
                'category' => 'music', 'type' => 'music', 'genre' => 'Rock',
                'title' => 'Metallica — 72 Seasons Album Review',
                'body'  => 'Metallica returns with their 12th studio album, a 77-minute behemoth that revisits their thrash roots while pushing into new sonic territory.',
                'year'  => 2023, 'views_count' => 1500, 'status' => 'published',
            ],

            // ── Sports ───────────────────────────────────────────────────────
            [
                'category' => 'sports', 'type' => 'other', 'genre' => 'Football',
                'title' => 'FIFA World Cup 2026 Preview: Teams to Watch',
                'body'  => 'With the expanded 48-team format, the 2026 World Cup promises to be the biggest in history. We break down the top contenders from every confederation.',
                'year'  => 2026, 'views_count' => 5100, 'status' => 'published',
            ],
            [
                'category' => 'sports', 'type' => 'other', 'genre' => 'Basketball',
                'title' => 'NBA Finals 2024 — Celtics Dynasty Begins',
                'body'  => 'The Boston Celtics claimed their 18th championship, defeating the Dallas Mavericks 4-1. Jaylen Brown was named Finals MVP in a dominant series.',
                'year'  => 2024, 'views_count' => 4200, 'status' => 'published',
            ],
            [
                'category' => 'sports', 'type' => 'other', 'genre' => 'Tennis',
                'title' => 'Carlos Alcaraz: The New King of Tennis',
                'body'  => 'At just 21, Carlos Alcaraz has already won four Grand Slams. We look at his playing style, mental strength, and what makes him so special.',
                'year'  => 2024, 'views_count' => 2100, 'status' => 'published',
            ],
            [
                'category' => 'sports', 'type' => 'other', 'genre' => 'Cricket',
                'title' => 'India T20 World Cup 2024 Champions',
                'body'  => 'India ended their 11-year ICC trophy drought by winning the T20 World Cup 2024, defeating South Africa in a nail-biting final in Barbados.',
                'year'  => 2024, 'views_count' => 6300, 'status' => 'published',
            ],

            // ── Gaming ───────────────────────────────────────────────────────
            [
                'category' => 'gaming', 'type' => 'game', 'genre' => 'RPG',
                'title' => 'Elden Ring Shadow of the Erdtree — Review',
                'body'  => 'FromSoftware\'s massive DLC expansion delivers some of the most challenging and rewarding content in the Soulsborne series. A must-play for fans.',
                'year'  => 2024, 'views_count' => 7200, 'status' => 'published',
            ],
            [
                'category' => 'gaming', 'type' => 'game', 'genre' => 'Action',
                'title' => 'Black Myth: Wukong — First Impressions',
                'body'  => 'China\'s first AAA game takes the gaming world by storm. Stunning visuals, fluid combat, and a rich mythology-based story make this a landmark release.',
                'year'  => 2024, 'views_count' => 8900, 'status' => 'published',
            ],
            [
                'category' => 'gaming', 'type' => 'game', 'genre' => 'Strategy',
                'title' => 'Civilization VII — What\'s New?',
                'body'  => 'Firaxis reinvents the Civilization formula with a new Age system, completely overhauled diplomacy, and a fresh approach to city building.',
                'year'  => 2025, 'views_count' => 3400, 'status' => 'published',
            ],
            [
                'category' => 'gaming', 'type' => 'other', 'genre' => 'Esports',
                'title' => 'League of Legends Worlds 2024 Recap',
                'body'  => 'T1 and Bilibili Gaming clashed in an epic Worlds final. We break down every game, the standout performances, and what it means for the competitive scene.',
                'year'  => 2024, 'views_count' => 4600, 'status' => 'published',
            ],

            // ── Film ─────────────────────────────────────────────────────────
            [
                'category' => 'film', 'type' => 'movie', 'genre' => 'Action',
                'title' => 'Dune: Part Two — A Cinematic Masterpiece',
                'body'  => 'Denis Villeneuve completes his adaptation of Frank Herbert\'s novel with breathtaking visuals, a stellar cast, and an emotionally resonant story.',
                'year'  => 2024, 'views_count' => 6800, 'status' => 'published',
            ],
            [
                'category' => 'film', 'type' => 'movie', 'genre' => 'Drama',
                'title' => 'Oppenheimer — Nolan\'s Magnum Opus',
                'body'  => 'Christopher Nolan\'s biopic of J. Robert Oppenheimer is a towering achievement in filmmaking — a three-hour epic that demands your full attention.',
                'year'  => 2023, 'views_count' => 5500, 'status' => 'published',
            ],
            [
                'category' => 'film', 'type' => 'movie', 'genre' => 'Horror',
                'title' => 'Alien: Romulus Review — The Franchise Returns',
                'body'  => 'Fede Álvarez strips the Alien franchise back to basics, delivering a genuinely terrifying survival horror film that honours the original.',
                'year'  => 2024, 'views_count' => 3100, 'status' => 'published',
            ],
            [
                'category' => 'film', 'type' => 'movie', 'genre' => 'Sci-Fi',
                'title' => 'Interstellar — 10 Years Later',
                'body'  => 'A decade on, Interstellar remains one of the most ambitious science fiction films ever made. We revisit its themes, science, and lasting cultural impact.',
                'year'  => 2024, 'views_count' => 2700, 'status' => 'published',
            ],

            // ── TV ───────────────────────────────────────────────────────────
            [
                'category' => 'tv', 'type' => 'series', 'genre' => 'Drama',
                'title' => 'The Last of Us Season 2 — Episode Guide',
                'body'  => 'HBO\'s adaptation of the beloved game returns with Bella Ramsey and Pedro Pascal navigating an even darker chapter of Ellie and Joel\'s story.',
                'year'  => 2025, 'views_count' => 9100, 'status' => 'published',
            ],
            [
                'category' => 'tv', 'type' => 'series', 'genre' => 'Thriller',
                'title' => 'Severance Season 2 — Everything We Know',
                'body'  => 'Apple TV+\'s mind-bending workplace thriller returns. We break down every trailer detail, fan theory, and what the Lumon Industries mystery might reveal.',
                'year'  => 2025, 'views_count' => 7400, 'status' => 'published',
            ],
            [
                'category' => 'tv', 'type' => 'series', 'genre' => 'Fantasy',
                'title' => 'House of the Dragon Season 2 Review',
                'body'  => 'The Dance of the Dragons heats up in Season 2. We review every episode of the Targaryen civil war saga and rank the best dragon battles.',
                'year'  => 2024, 'views_count' => 5800, 'status' => 'published',
            ],
            [
                'category' => 'tv', 'type' => 'series', 'genre' => 'Comedy',
                'title' => 'Abbott Elementary Season 3 — Why It\'s the Best Comedy on TV',
                'body'  => 'Abbott Elementary continues to be the funniest and most heartfelt show on network television. Season 3 raises the stakes for every character.',
                'year'  => 2024, 'views_count' => 2300, 'status' => 'published',
            ],

            // ── Anime ────────────────────────────────────────────────────────
            [
                'category' => 'anime', 'type' => 'anime', 'genre' => 'Shonen',
                'title' => 'Demon Slayer — Infinity Castle Arc Preview',
                'body'  => 'The most anticipated arc in Demon Slayer history is finally here. We preview the Infinity Castle movie trilogy and what fans can expect.',
                'year'  => 2025, 'views_count' => 11200, 'status' => 'published',
            ],
            [
                'category' => 'anime', 'type' => 'anime', 'genre' => 'Shonen',
                'title' => 'Jujutsu Kaisen Season 3 — Culling Game Begins',
                'body'  => 'The Culling Game arc brings the most complex and brutal battles in JJK history. Gege Akutami\'s storytelling reaches new heights of chaos and emotion.',
                'year'  => 2025, 'views_count' => 9800, 'status' => 'published',
            ],
            [
                'category' => 'anime', 'type' => 'anime', 'genre' => 'Seinen',
                'title' => 'Vinland Saga Season 2 — A Masterclass in Character Growth',
                'body'  => 'Thorfinn\'s journey from revenge-driven warrior to pacifist is one of the greatest character arcs in anime history. Season 2 is unmissable.',
                'year'  => 2023, 'views_count' => 4400, 'status' => 'published',
            ],
            [
                'category' => 'anime', 'type' => 'anime', 'genre' => 'Isekai',
                'title' => 'Frieren: Beyond Journey\'s End — Why Everyone Is Talking About It',
                'body'  => 'Frieren defies isekai conventions with its meditative pace, stunning animation, and deeply moving exploration of memory, mortality, and connection.',
                'year'  => 2024, 'views_count' => 6700, 'status' => 'published',
            ],

            // ── Art ──────────────────────────────────────────────────────────
            [
                'category' => 'art', 'type' => 'art', 'genre' => 'Digital',
                'title' => 'The Rise of AI Art — Creative Tool or Threat?',
                'body'  => 'AI image generation tools like Midjourney and DALL-E have sparked fierce debate in the art community. We explore both sides of the argument.',
                'year'  => 2024, 'views_count' => 3800, 'status' => 'published',
            ],
            [
                'category' => 'art', 'type' => 'art', 'genre' => 'Illustration',
                'title' => 'Top 10 Concept Artists of 2024',
                'body'  => 'From game concept art to film production design, these are the ten artists whose work defined the visual landscape of 2024.',
                'year'  => 2024, 'views_count' => 2600, 'status' => 'published',
            ],
            [
                'category' => 'art', 'type' => 'art', 'genre' => 'Street Art',
                'title' => 'Banksy\'s 2024 London Series Explained',
                'body'  => 'Banksy returned to London streets with a series of politically charged murals. We decode the symbolism and message behind each piece.',
                'year'  => 2024, 'views_count' => 1900, 'status' => 'published',
            ],

            // ── Tech ─────────────────────────────────────────────────────────
            [
                'category' => 'tech', 'type' => 'other', 'genre' => 'AI',
                'title' => 'GPT-5 vs Claude 4 — The AI Battle of 2025',
                'body'  => 'OpenAI and Anthropic go head to head with their latest flagship models. We run comprehensive benchmarks across reasoning, coding, and creativity tasks.',
                'year'  => 2025, 'views_count' => 12400, 'status' => 'published',
            ],
            [
                'category' => 'tech', 'type' => 'other', 'genre' => 'Hardware',
                'title' => 'Apple Vision Pro — Six Months Later',
                'body'  => 'Six months after launch, we revisit Apple Vision Pro. Has the killer app arrived? Is spatial computing ready for the mainstream? Our honest verdict.',
                'year'  => 2024, 'views_count' => 5200, 'status' => 'published',
            ],
            [
                'category' => 'tech', 'type' => 'other', 'genre' => 'Software',
                'title' => 'Laravel 12 — What\'s New and What Changed',
                'body'  => 'Laravel 12 brings significant improvements to the framework including enhanced Eloquent features, improved testing tools, and a revamped starter kit system.',
                'year'  => 2025, 'views_count' => 3300, 'status' => 'published',
            ],
            [
                'category' => 'tech', 'type' => 'other', 'genre' => 'Gadgets',
                'title' => 'Samsung Galaxy S25 Ultra Full Review',
                'body'  => 'Samsung\'s flagship phone for 2025 packs a Snapdragon 8 Elite chip, a redesigned titanium frame, and the most capable mobile camera system ever made.',
                'year'  => 2025, 'views_count' => 4100, 'status' => 'published',
            ],
        ];

        foreach ($items as $item) {
            $categoryId = $cat[$item['category']] ?? null;
            if (! $categoryId) {
                continue;
            }

            Content::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($item['title'])],
                [
                    'user_id'     => $admin->id,
                    'category_id' => $categoryId,
                    'title'       => $item['title'],
                    'body'        => $item['body'],
                    'status'      => $item['status'],
                    'genre'       => $item['genre'],
                    'year'        => $item['year'],
                    'type'        => $item['type'],
                    'views_count' => $item['views_count'],
                    'thumbnail'   => null,
                ]
            );
        }
    }
}
