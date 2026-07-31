<?php

namespace Database\Seeders;

use App\Models\InstagramImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstagramImagesSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        InstagramImage::create([
            'title' => 'New Collection Drop',
            'image' => 'images/instagram/placeholder-1.svg',
        ]);

        InstagramImage::create([
            'title' => 'Style of the Week',
            'image' => 'images/instagram/placeholder-2.svg',
        ]);

        InstagramImage::create([
            'title' => 'Customer Favorites',
            'image' => 'images/instagram/placeholder-3.svg',
        ]);
    }
}
