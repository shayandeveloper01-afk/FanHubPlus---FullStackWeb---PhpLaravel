<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Merchandise;
use App\Models\MerchandiseTag;
use App\Models\User;
use Illuminate\Database\Seeder;

class MerchandiseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        // Tags
        $tags = [
            ['name' => 'Limited Edition', 'slug' => 'limited-edition'],
            ['name' => 'Pre-Order',       'slug' => 'pre-order'],
            ['name' => 'Collectible',     'slug' => 'collectible'],
        ];
        foreach ($tags as $t) {
            MerchandiseTag::firstOrCreate(['slug' => $t['slug']], ['name' => $t['name']]);
        }

        $limited    = MerchandiseTag::where('slug', 'limited-edition')->first();
        $preOrder   = MerchandiseTag::where('slug', 'pre-order')->first();
        $collectible = MerchandiseTag::where('slug', 'collectible')->first();

        $anime  = Category::where('slug', 'anime')->first();
        $gaming = Category::where('slug', 'gaming')->first();
        $music  = Category::where('slug', 'music')->first();
        $film   = Category::where('slug', 'film')->first();

        $items = [
            [
                'title'       => 'Akira Kaneda Jacket — Replica',
                'description' => 'High-quality replica of the iconic red jacket from Akira. Embroidered patches, genuine leather feel.',
                'price'       => 149.99,
                'currency'    => 'USD',
                'category'    => $anime,
                'tags'        => [$limited, $collectible],
                'views_count' => 1240,
            ],
            [
                'title'       => 'Cyberpunk 2077 Night City Poster Set',
                'description' => 'Set of 4 high-resolution art prints from Night City. 18×24 inches, matte finish.',
                'price'       => 39.99,
                'currency'    => 'USD',
                'category'    => $gaming,
                'tags'        => [],
                'views_count' => 870,
            ],
            [
                'title'       => 'Daft Punk Helmet Replica (Discovery Era)',
                'description' => 'Wearable replica helmet inspired by the Discovery album era. LED lighting included.',
                'price'       => 299.00,
                'currency'    => 'USD',
                'category'    => $music,
                'tags'        => [$limited, $collectible],
                'views_count' => 2100,
            ],
            [
                'title'       => 'Blade Runner 2049 Spinner Model Kit',
                'description' => 'Die-cast metal model of the iconic Spinner vehicle. 1:43 scale, display stand included.',
                'price'       => 89.95,
                'currency'    => 'USD',
                'category'    => $film,
                'tags'        => [$collectible],
                'views_count' => 560,
            ],
            [
                'title'       => 'Elden Ring Tarnished Enamel Pin Set',
                'description' => 'Set of 6 hard enamel pins featuring iconic symbols from the Lands Between.',
                'price'       => 24.99,
                'currency'    => 'USD',
                'category'    => $gaming,
                'tags'        => [$preOrder],
                'views_count' => 430,
            ],
            [
                'title'       => 'Ghost in the Shell Section 9 Badge',
                'description' => 'Official-style Section 9 badge prop replica. Metal construction with display case.',
                'price'       => 59.00,
                'currency'    => 'USD',
                'category'    => $anime,
                'tags'        => [$limited],
                'views_count' => 780,
            ],
            [
                'title'       => 'Radiohead OK Computer Vinyl (Repress)',
                'description' => '180g heavyweight vinyl repress of the landmark 1997 album. Gatefold sleeve.',
                'price'       => 34.99,
                'currency'    => 'USD',
                'category'    => $music,
                'tags'        => [$preOrder],
                'views_count' => 320,
            ],
            [
                'title'       => 'The Last of Us Part II Ellie Tattoo Sleeve',
                'description' => 'Temporary tattoo sleeve replicating Ellie\'s iconic arm tattoo. Waterproof, lasts 7 days.',
                'price'       => 12.99,
                'currency'    => 'USD',
                'category'    => $gaming,
                'tags'        => [],
                'views_count' => 210,
            ],
        ];

        foreach ($items as $data) {
            if (! $data['category']) continue;

            $merch = Merchandise::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($data['title'])],
                [
                    'user_id'     => $admin->id,
                    'category_id' => $data['category']->id,
                    'title'       => $data['title'],
                    'description' => $data['description'],
                    'price'       => $data['price'],
                    'currency'    => $data['currency'],
                    'status'      => 'active',
                    'views_count' => $data['views_count'],
                ]
            );

            if ($data['tags']) {
                $merch->tags()->sync(collect($data['tags'])->filter()->pluck('id'));
            }
        }
    }
}
