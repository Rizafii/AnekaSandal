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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('province_id', 10)->nullable()->after('shipping_postal_code');
            $table->string('city_id', 10)->nullable()->after('province_id');
            $table->string('district_id', 10)->nullable()->after('city_id');
            $table->string('shipping_service', 100)->nullable()->after('courier')->comment('layanan pengiriman dari raja ongkir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['province_id', 'city_id', 'district_id', 'shipping_service']);
        });
    }
};
