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
                'product_id' => 1,
                'variant_id' => 1, // Size 39, Hitam
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // customer1
                'product_id' => 4,
                'variant_id' => 14, // Size 38, Hitam (Sandal Jepit)
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // customer2
                'product_id' => 2,
                'variant_id' => 6, // Size 36, Merah (Sandal Wanita Elegant)
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // customer2
                'product_id' => 6,
                'variant_id' => 20, // Size 36, Beige (Sandal Flat Wanita)
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4, // customer3
                'product_id' => 5,
                'variant_id' => 17, // Size 41, Abu-abu (Sandal Gunung)
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5, // customer4
                'product_id' => 3,
                'variant_id' => 10, // Size 25, Pink (Sandal Anak)
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('cart')->insert($cartItems);
    }
}
