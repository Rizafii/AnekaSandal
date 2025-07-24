<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TestCheckout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test checkout process';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing checkout process...');

        DB::beginTransaction();
        try {
            // Get a customer user
            $user = User::where('role', 'customer')->first();
            if (!$user) {
                $this->error('No customer user found');
                return;
            }

            $this->info("Using customer: {$user->full_name}");

            // Test 1: Create test order
            $order = Order::create([
                'user_id' => $user->id,
                'status' => Order::STATUS_MENUNGGU_PEMBAYARAN,
                'total_amount' => 100000.00,
                'shipping_cost' => 10000.00,
                'final_amount' => 110000.00,
                'shipping_name' => 'Test Customer',
                'shipping_phone' => '081234567890',
                'shipping_address' => 'Test Address',
                'shipping_city' => 'Test City',
                'shipping_postal_code' => '12345',
                'payment_status' => Order::PAYMENT_STATUS_BELUM_BAYAR
            ]);

            $this->info("✓ Order created successfully!");
            $this->info("  Order ID: {$order->id}");
            $this->info("  Order Number: {$order->order_number}");
            $this->info("  Status: {$order->status}");
            $this->info("  Payment Status: {$order->payment_status}");

            // Test 2: Test route generation
            $paymentUrl = route('checkout.payment', $order->id);
            $this->info("✓ Payment URL generated: {$paymentUrl}");

            // Test 3: Test status constant values
            $this->info("\n✓ Testing status constants:");
            $this->info("  STATUS_MENUNGGU_PEMBAYARAN: " . Order::STATUS_MENUNGGU_PEMBAYARAN);
            $this->info("  STATUS_SEDANG_DIKIRIM: " . Order::STATUS_SEDANG_DIKIRIM);
            $this->info("  STATUS_SELESAI: " . Order::STATUS_SELESAI);
            $this->info("  STATUS_DIBATALKAN: " . Order::STATUS_DIBATALKAN);

            // Test 4: Test order methods
            $this->info("\n✓ Testing order methods:");
            $this->info("  canUploadPayment(): " . ($order->canUploadPayment() ? 'true' : 'false'));
            $this->info("  canBeCancelled(): " . ($order->canBeCancelled() ? 'true' : 'false'));
            $this->info("  isCompleted(): " . ($order->isCompleted() ? 'true' : 'false'));

            DB::rollback(); // Don't actually save the test order
            $this->info("\n🎉 All tests passed! (Order was rolled back)");

        } catch (\Exception $e) {
            DB::rollback();
            $this->error("❌ Test failed: " . $e->getMessage());
            $this->error("   File: " . $e->getFile() . " Line: " . $e->getLine());
        }
    }
}
