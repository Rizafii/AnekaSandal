<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'id' => 1,
                'category_id' => 1,
                'name' => 'Sandal Pria Casual Brown',
                'slug' => 'sandal-pria-casual-brown',
                'description' => 'Sandal pria dengan desain casual yang nyaman untuk aktivitas sehari-hari. Terbuat dari bahan kulit sintetis berkualitas tinggi.',
                'price' => 75000.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'category_id' => 2,
                'name' => 'Sandal Wanita Elegant Red',
                'slug' => 'sandal-wanita-elegant-red',
                'description' => 'Sandal wanita elegant dengan hak rendah, cocok untuk acara formal maupun kasual. Material kulit yang lembut dan nyaman.',
                'price' => 85000.00,
                'weight' => 400,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'category_id' => 3,
                'name' => 'Sandal Anak Lucu Pink',
                'slug' => 'sandal-anak-lucu-pink',
                'description' => 'Sandal anak dengan desain lucu dan warna-warna cerah. Sol anti slip untuk keamanan anak saat bermain.',
                'price' => 40000.00,
                'weight' => 250,
                'is_active' => true,
                'featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'category_id' => 4,
                'name' => 'Sandal Jepit Rubber Black',
                'slug' => 'sandal-jepit-rubber-black',
                'description' => 'Sandal jepit berbahan karet berkualitas, ringan dan tahan lama. Cocok untuk aktivitas pantai dan santai.',
                'price' => 35000.00,
                'weight' => 300,
                'is_active' => true,
                'featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'category_id' => 5,
                'name' => 'Sandal Gunung Outdoor Grey',
                'slug' => 'sandal-gunung-outdoor-grey',
                'description' => 'Sandal gunung dengan grip maksimal dan bantalan yang empuk. Ideal untuk hiking dan aktivitas outdoor.',
                'price' => 150000.00,
                'weight' => 800,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'category_id' => 2,
                'name' => 'Sandal Flat Wanita Beige',
                'slug' => 'sandal-flat-wanita-beige',
                'description' => 'Sandal flat wanita dengan desain minimalis dan elegan. Nyaman dipakai seharian untuk berbagai aktivitas.',
                'price' => 65000.00,
                'weight' => 350,
                'is_active' => true,
                'featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'category_id' => 1,
                'name' => 'Sandal Sport Pria Blue',
                'slug' => 'sandal-sport-pria-blue',
                'description' => 'Sandal sport pria dengan teknologi EVA sole yang ringan dan empuk. Cocok untuk olahraga ringan dan aktivitas harian.',
                'price' => 50000.00,
                'weight' => 450,
                'is_active' => true,
                'featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'category_id' => 2,
                'name' => 'Sandal Platform Wanita Gold',
                'slug' => 'sandal-platform-wanita-gold',
                'description' => 'Sandal platform wanita dengan aksen gold yang mewah. Memberikan tinggi tambahan dengan tetap nyaman dipakai.',
                'price' => 95000.00,
                'weight' => 600,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('products')->insert($products);
    }
}
