<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Anime', '#ec4899', 'play-circle'],
            ['TV Series', '#8b5cf6', 'tv'],
            ['Movies', '#06b6d4', 'film'],
            ['Manga', '#f59e0b', 'book-open'],
            ['Comics', '#10b981', 'zap'],
            ['Gaming', '#6366f1', 'gamepad'],
            ['Cosplay', '#f43f5e', 'user-circle'],
            ['Events', '#a855f7', 'calendar'],
        ];

        foreach ($categories as $index => [$name, $color, $icon]) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $name . ' fandom content and community.',
                    'status' => 'active',
                    'color' => $color,
                    'sort_order' => $index + 1,
                    'icon_svg' => '<svg viewBox="0 0 24 24" aria-hidden="true" data-icon="' . $icon . '"></svg>',
                ]
            );
        }
    }
}
