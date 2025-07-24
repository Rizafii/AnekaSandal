<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cartItems = [
            [
                'user_id' => 2, // customer1
                'product_id' => 8,
                'variant_id' => 26, // Platform Gold Size 36
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // customer1
                'product_id' => 4,
                'variant_id' => 16, // Jepit Size 40
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // customer2
                'product_id' => 7,
                'variant_id' => 24, // Sport Pria Size 41
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // customer2
                'product_id' => 6,
                'variant_id' => 21, // Flat Wanita Size 37
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4, // customer3
                'product_id' => 1,
                'variant_id' => 3, // Casual Pria Size 41
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5, // customer4
                'product_id' => 2,
                'variant_id' => 7, // Elegant Wanita Size 37
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('cart')->insert($cartItems);
    }
}
