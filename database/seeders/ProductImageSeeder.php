<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productImages = [
            // Product 1 - Sandal Pria Casual
            [
                'product_id' => 1,
                'image_path' => 'products/sandal-pria-casual-1.jpg',
                'alt_text' => 'Sandal Pria Casual - Tampak Depan',
                'is_primary' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'image_path' => 'products/sandal-pria-casual-2.jpg',
                'alt_text' => 'Sandal Pria Casual - Tampak Samping',
                'is_primary' => false,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 2 - Sandal Wanita Elegant
            [
                'product_id' => 2,
                'image_path' => 'products/sandal-wanita-elegant-1.jpg',
                'alt_text' => 'Sandal Wanita Elegant - Tampak Depan',
                'is_primary' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'image_path' => 'products/sandal-wanita-elegant-2.jpg',
                'alt_text' => 'Sandal Wanita Elegant - Detail',
                'is_primary' => false,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 3 - Sandal Anak Lucu
            [
                'product_id' => 3,
                'image_path' => 'products/sandal-anak-lucu-1.jpg',
                'alt_text' => 'Sandal Anak Lucu - Tampak Depan',
                'is_primary' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 4 - Sandal Jepit Rubber
            [
                'product_id' => 4,
                'image_path' => 'products/sandal-jepit-rubber-1.jpg',
                'alt_text' => 'Sandal Jepit Rubber - Tampak Depan',
                'is_primary' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 5 - Sandal Gunung Outdoor
            [
                'product_id' => 5,
                'image_path' => 'products/sandal-gunung-outdoor-1.jpg',
                'alt_text' => 'Sandal Gunung Outdoor - Tampak Depan',
                'is_primary' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'image_path' => 'products/sandal-gunung-outdoor-2.jpg',
                'alt_text' => 'Sandal Gunung Outdoor - Sol',
                'is_primary' => false,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 6 - Sandal Flat Wanita
            [
                'product_id' => 6,
                'image_path' => 'products/sandal-flat-wanita-1.jpg',
                'alt_text' => 'Sandal Flat Wanita - Tampak Depan',
                'is_primary' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 7 - Sandal Sport Pria
            [
                'product_id' => 7,
                'image_path' => 'products/sandal-sport-pria-1.jpg',
                'alt_text' => 'Sandal Sport Pria - Tampak Depan',
                'is_primary' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 8 - Sandal Platform Wanita
            [
                'product_id' => 8,
                'image_path' => 'products/sandal-platform-wanita-1.jpg',
                'alt_text' => 'Sandal Platform Wanita - Tampak Depan',
                'is_primary' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('product_images')->insert($productImages);
    }
}
