<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder dalam urutan yang benar sesuai foreign key constraints
        $this->call([
            UserSeeder::class,           // Users harus pertama (banyak tabel reference ke users)
            CategorySeeder::class,       // Categories
            ProductSeeder::class,        // Products (reference ke categories)
                // ProductImageSeeder::class,   // Product Images (reference ke products)
            ProductVariantSeeder::class, // Product Variants (reference ke products)
            CartSeeder::class,           // Cart (reference ke users, products, variants)
            OrderSeeder::class,          // Orders (reference ke users)
            OrderItemSeeder::class,      // Order Items (reference ke orders, products, variants)
            OrderStatusLogSeeder::class, // Order Status Logs (reference ke orders, users)
        ]);
    }
}
