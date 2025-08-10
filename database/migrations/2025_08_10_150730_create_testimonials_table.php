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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->default(5)->comment('Rating 1-5 bintang');
            $table->text('review')->nullable()->comment('Deskripsi testimoni');
            $table->string('image_path')->nullable()->comment('Path foto testimoni');
            $table->boolean('is_approved')->default(true)->comment('Status persetujuan admin');
            $table->timestamps();

            // Indexes
            $table->index(['product_id', 'is_approved']);
            $table->index(['user_id']);
            $table->index(['order_id']);

            // Constraint: user hanya bisa beri testimoni sekali per order+product
            $table->unique(['order_id', 'product_id'], 'unique_order_product_testimonial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
