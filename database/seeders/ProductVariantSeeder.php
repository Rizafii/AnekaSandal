<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variants = [
            // Product 1 - Sandal Pria Casual
            [
                'product_id' => 1,
                'size' => '39',
                'color' => 'Hitam',
                'additional_price' => 0.00,
                'stock' => 15,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'size' => '40',
                'color' => 'Hitam',
                'additional_price' => 0.00,
                'stock' => 20,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'size' => '41',
                'color' => 'Hitam',
                'additional_price' => 0.00,
                'stock' => 18,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'size' => '42',
                'color' => 'Hitam',
                'additional_price' => 0.00,
                'stock' => 22,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'size' => '40',
                'color' => 'Coklat',
                'additional_price' => 5000.00,
                'stock' => 12,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 2 - Sandal Wanita Elegant
            [
                'product_id' => 2,
                'size' => '36',
                'color' => 'Merah',
                'additional_price' => 0.00,
                'stock' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'size' => '37',
                'color' => 'Merah',
                'additional_price' => 0.00,
                'stock' => 15,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'size' => '38',
                'color' => 'Merah',
                'additional_price' => 0.00,
                'stock' => 12,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'size' => '37',
                'color' => 'Navy',
                'additional_price' => 3000.00,
                'stock' => 8,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 3 - Sandal Anak Lucu
            [
                'product_id' => 3,
                'size' => '25',
                'color' => 'Pink',
                'additional_price' => 0.00,
                'stock' => 20,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'size' => '26',
                'color' => 'Pink',
                'additional_price' => 0.00,
                'stock' => 18,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'size' => '27',
                'color' => 'Pink',
                'additional_price' => 0.00,
                'stock' => 15,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'size' => '26',
                'color' => 'Biru',
                'additional_price' => 2000.00,
                'stock' => 12,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 4 - Sandal Jepit Rubber
            [
                'product_id' => 4,
                'size' => '38',
                'color' => 'Hitam',
                'additional_price' => 0.00,
                'stock' => 25,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'size' => '39',
                'color' => 'Hitam',
                'additional_price' => 0.00,
                'stock' => 30,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'size' => '40',
                'color' => 'Hitam',
                'additional_price' => 0.00,
                'stock' => 28,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 5 - Sandal Gunung Outdoor
            [
                'product_id' => 5,
                'size' => '41',
                'color' => 'Abu-abu',
                'additional_price' => 0.00,
                'stock' => 8,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'size' => '42',
                'color' => 'Abu-abu',
                'additional_price' => 0.00,
                'stock' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'size' => '43',
                'color' => 'Abu-abu',
                'additional_price' => 0.00,
                'stock' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 6 - Sandal Flat Wanita
            [
                'product_id' => 6,
                'size' => '36',
                'color' => 'Beige',
                'additional_price' => 0.00,
                'stock' => 14,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 6,
                'size' => '37',
                'color' => 'Beige',
                'additional_price' => 0.00,
                'stock' => 16,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 6,
                'size' => '38',
                'color' => 'Beige',
                'additional_price' => 0.00,
                'stock' => 12,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 7 - Sandal Sport Pria
            [
                'product_id' => 7,
                'size' => '40',
                'color' => 'Biru',
                'additional_price' => 0.00,
                'stock' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 7,
                'size' => '41',
                'color' => 'Biru',
                'additional_price' => 0.00,
                'stock' => 12,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 7,
                'size' => '42',
                'color' => 'Biru',
                'additional_price' => 0.00,
                'stock' => 8,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 8 - Sandal Platform Wanita
            [
                'product_id' => 8,
                'size' => '36',
                'color' => 'Gold',
                'additional_price' => 0.00,
                'stock' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 8,
                'size' => '37',
                'color' => 'Gold',
                'additional_price' => 0.00,
                'stock' => 8,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 8,
                'size' => '38',
                'color' => 'Gold',
                'additional_price' => 0.00,
                'stock' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('product_variants')->insert($variants);
    }
}
