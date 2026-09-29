<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
            ContentSeeder::class,
            ContentVideoSeeder::class,
            MerchandiseSeeder::class,
            EventSeeder::class,
            CatalogArtworkSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
