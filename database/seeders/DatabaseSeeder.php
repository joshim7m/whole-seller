<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            CatalogSeeder::class,
            OrderSeeder::class,
            SettingsSeeder::class,
            InstagramImagesSeeder::class,
            SocialMediaSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}
