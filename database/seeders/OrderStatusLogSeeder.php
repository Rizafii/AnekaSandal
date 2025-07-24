<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusLogs = [
            // Order 1 - Selesai
            [
                'order_id' => 1,
                'status' => 'menunggu_pembayaran',
                'notes' => 'Order dibuat, menunggu pembayaran dari customer',
                'changed_by' => null,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'order_id' => 1,
                'status' => 'sedang_dikirim',
                'notes' => 'Pembayaran telah dikonfirmasi, barang sedang dikemas dan dikirim',
                'changed_by' => 1, // admin
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'order_id' => 1,
                'status' => 'selesai',
                'notes' => 'Barang telah sampai ke customer',
                'changed_by' => 1, // admin
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],

            // Order 2 - Sedang dikirim
            [
                'order_id' => 2,
                'status' => 'menunggu_pembayaran',
                'notes' => 'Order dibuat, menunggu pembayaran',
                'changed_by' => null,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'order_id' => 2,
                'status' => 'sedang_dikirim',
                'notes' => 'Pembayaran dikonfirmasi, barang sedang dalam perjalanan',
                'changed_by' => 1, // admin
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],

            // Order 3 - Menunggu pembayaran
            [
                'order_id' => 3,
                'status' => 'menunggu_pembayaran',
                'notes' => 'Order baru dibuat, customer belum melakukan pembayaran',
                'changed_by' => null,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],

            // Order 4 - Menunggu konfirmasi pembayaran
            [
                'order_id' => 4,
                'status' => 'menunggu_pembayaran',
                'notes' => 'Order dibuat',
                'changed_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Order 5 - Dibatalkan
            [
                'order_id' => 5,
                'status' => 'menunggu_pembayaran',
                'notes' => 'Order dibuat',
                'changed_by' => null,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'order_id' => 5,
                'status' => 'dibatalkan',
                'notes' => 'Order dibatalkan karena stok produk tidak tersedia',
                'changed_by' => 1, // admin
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ]
        ];

        DB::table('order_status_logs')->insert($statusLogs);
    }
}
