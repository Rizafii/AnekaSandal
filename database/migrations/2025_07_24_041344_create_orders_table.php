<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->string('order_number', 50)->unique();
            $table->enum('status', ['menunggu_pembayaran', 'sedang_dikirm', 'selesai', 'dibatalkan'])->default('menunggu_pembayaran');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);

            // Data pengiriman
            $table->string('shipping_name', 100);
            $table->string('shipping_phone', 20);
            $table->text('shipping_address');
            $table->string('shipping_city', 100)->nullable();
            $table->string('shipping_postal_code', 10)->nullable();

            // Data pembayaran
            $table->string('payment_proof')->nullable()->comment('path ke file bukti transfer');
            $table->enum('payment_status', ['belum_bayar', 'menunggu_konfirmasi', 'terkonfirmasi', 'ditolak'])->default('belum_bayar');

            // Tracking
            $table->string('tracking_number', 100)->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['status']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
