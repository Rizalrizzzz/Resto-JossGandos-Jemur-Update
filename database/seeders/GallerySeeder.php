<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        Gallery::create([
            'title' => 'Bebek Goreng',
            'category' => 'food',
            'image_path' => 'img/bebekgoreng.jpg',
        ]);

        Gallery::create([
            'title' => 'Customer 1',
            'category' => 'customer',
            'image_path' => 'img/customer1.jpg',
        ]);
    }
}
