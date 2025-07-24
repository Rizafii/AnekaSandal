<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderItems = [
            // Order 1 - ORD-001 (customer1)
            [
                'order_id' => 1,
                'product_id' => 1,
                'variant_id' => 1,
                'product_name' => 'Sandal Pria Casual',
                'variant_info' => 'Size: 39, Warna: Hitam',
                'price' => 75000.00,
                'quantity' => 2,
                'subtotal' => 150000.00,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],

            // Order 2 - ORD-002 (customer2)
            [
                'order_id' => 2,
                'product_id' => 2,
                'variant_id' => 6,
                'product_name' => 'Sandal Wanita Elegant',
                'variant_info' => 'Size: 36, Warna: Merah',
                'price' => 85000.00,
                'quantity' => 1,
                'subtotal' => 85000.00,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'order_id' => 2,
                'product_id' => 4,
                'variant_id' => 14,
                'product_name' => 'Sandal Jepit Rubber',
                'variant_info' => 'Size: 38, Warna: Hitam',
                'price' => 35000.00,
                'quantity' => 1,
                'subtotal' => 35000.00,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],

            // Order 3 - ORD-003 (customer3)
            [
                'order_id' => 3,
                'product_id' => 5,
                'variant_id' => 17,
                'product_name' => 'Sandal Gunung Outdoor',
                'variant_info' => 'Size: 41, Warna: Abu-abu',
                'price' => 150000.00,
                'quantity' => 1,
                'subtotal' => 150000.00,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'order_id' => 3,
                'product_id' => 7,
                'variant_id' => 23,
                'product_name' => 'Sandal Sport Pria',
                'variant_info' => 'Size: 40, Warna: Biru',
                'price' => 50000.00,
                'quantity' => 1,
                'subtotal' => 50000.00,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],

            // Order 4 - ORD-004 (customer4)
            [
                'order_id' => 4,
                'product_id' => 3,
                'variant_id' => 10,
                'product_name' => 'Sandal Anak Lucu',
                'variant_info' => 'Size: 25, Warna: Pink',
                'price' => 40000.00,
                'quantity' => 2,
                'subtotal' => 80000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Order 5 - ORD-005 (customer1 - dibatalkan)
            [
                'order_id' => 5,
                'product_id' => 6,
                'variant_id' => 20,
                'product_name' => 'Sandal Flat Wanita',
                'variant_info' => 'Size: 36, Warna: Beige',
                'price' => 65000.00,
                'quantity' => 1,
                'subtotal' => 65000.00,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'order_id' => 5,
                'product_id' => 4,
                'variant_id' => 15,
                'product_name' => 'Sandal Jepit Rubber',
                'variant_info' => 'Size: 39, Warna: Hitam',
                'price' => 35000.00,
                'quantity' => 1,
                'subtotal' => 35000.00,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ]
        ];

        DB::table('order_items')->insert($orderItems);
    }
}
