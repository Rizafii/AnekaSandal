<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [
            [
                'id' => 1,
                'user_id' => 2, // customer1
                'order_number' => 'AS-' . date('Ymd') . '-001',
                'status' => 'selesai',
                'total_amount' => 150000.00,
                'shipping_cost' => 15000.00,
                'final_amount' => 165000.00,
                'shipping_name' => 'Budi Santoso',
                'shipping_phone' => '081234567891',
                'shipping_address' => 'Jl. Mawar No. 10, Bandung',
                'shipping_city' => 'Bandung',
                'shipping_postal_code' => '40123',
                'payment_proof' => 'payments/proof-001.jpg',
                'payment_status' => 'terkonfirmasi',
                'tracking_number' => 'JNE123456789',
                'shipped_at' => now()->subDays(3),
                'delivered_at' => now()->subDays(1),
                'notes' => 'Pesanan pertama customer',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(1),
            ],
            [
                'id' => 2,
                'user_id' => 3, // customer2
                'order_number' => 'AS-' . date('Ymd') . '-002',
                'status' => 'sedang_dikirim',
                'total_amount' => 120000.00,
                'shipping_cost' => 12000.00,
                'final_amount' => 132000.00,
                'shipping_name' => 'Siti Nurhaliza',
                'shipping_phone' => '081234567892',
                'shipping_address' => 'Jl. Melati No. 15, Surabaya',
                'shipping_city' => 'Surabaya',
                'shipping_postal_code' => '60234',
                'payment_proof' => 'payments/proof-002.jpg',
                'payment_status' => 'terkonfirmasi',
                'tracking_number' => 'TIKI987654321',
                'shipped_at' => now()->subDays(1),
                'delivered_at' => null,
                'notes' => null,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(1),
            ],
            [
                'id' => 3,
                'user_id' => 4, // customer3
                'order_number' => 'AS-' . date('Ymd') . '-003',
                'status' => 'menunggu_pembayaran',
                'total_amount' => 200000.00,
                'shipping_cost' => 18000.00,
                'final_amount' => 218000.00,
                'shipping_name' => 'Ahmad Fauzi',
                'shipping_phone' => '081234567893',
                'shipping_address' => 'Jl. Kenanga No. 20, Yogyakarta',
                'shipping_city' => 'Yogyakarta',
                'shipping_postal_code' => '55123',
                'payment_proof' => null,
                'payment_status' => 'belum_bayar',
                'tracking_number' => null,
                'shipped_at' => null,
                'delivered_at' => null,
                'notes' => 'Menunggu pembayaran dari customer',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'id' => 4,
                'user_id' => 5, // customer4
                'order_number' => 'AS-' . date('Ymd') . '-004',
                'status' => 'menunggu_pembayaran',
                'total_amount' => 80000.00,
                'shipping_cost' => 10000.00,
                'final_amount' => 90000.00,
                'shipping_name' => 'Rina Kartika',
                'shipping_phone' => '081234567894',
                'shipping_address' => 'Jl. Anggrek No. 25, Semarang',
                'shipping_city' => 'Semarang',
                'shipping_postal_code' => '50234',
                'payment_proof' => 'payments/proof-004.jpg',
                'payment_status' => 'menunggu_konfirmasi',
                'tracking_number' => null,
                'shipped_at' => null,
                'delivered_at' => null,
                'notes' => 'Customer sudah upload bukti pembayaran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'user_id' => 2, // customer1 - pesanan kedua
                'order_number' => 'AS-' . date('Ymd') . '-005',
                'status' => 'dibatalkan',
                'total_amount' => 100000.00,
                'shipping_cost' => 12000.00,
                'final_amount' => 112000.00,
                'shipping_name' => 'Budi Santoso',
                'shipping_phone' => '081234567891',
                'shipping_address' => 'Jl. Mawar No. 10, Bandung',
                'shipping_city' => 'Bandung',
                'shipping_postal_code' => '40123',
                'payment_proof' => null,
                'payment_status' => 'belum_bayar',
                'tracking_number' => null,
                'shipped_at' => null,
                'delivered_at' => null,
                'notes' => 'Dibatalkan karena stok habis',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ]
        ];

        DB::table('orders')->insert($orders);
    }
}
