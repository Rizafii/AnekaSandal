<?php

namespace Database\Seeders;

use App\Models\StoreSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Store Information
            [
                'key' => 'store_name',
                'value' => 'Aneka Sandal',
                'type' => 'string',
                'description' => 'Nama toko',
                'group' => 'store_info'
            ],
            [
                'key' => 'store_address',
                'value' => 'Jl. Raya No. 123, Jakarta',
                'type' => 'string',
                'description' => 'Alamat lengkap toko',
                'group' => 'store_info'
            ],
            [
                'key' => 'store_phone',
                'value' => '+62812-3456-7890',
                'type' => 'string',
                'description' => 'Nomor telepon toko',
                'group' => 'store_info'
            ],
            [
                'key' => 'store_email',
                'value' => 'info@anekasandal.com',
                'type' => 'string',
                'description' => 'Email toko',
                'group' => 'store_info'
            ],

            // Shipping Settings
            [
                'key' => 'shipping_origin_province_id',
                'value' => '6',
                'type' => 'string',
                'description' => 'ID Provinsi asal pengiriman (RajaOngkir)',
                'group' => 'shipping'
            ],
            [
                'key' => 'shipping_origin_city_id',
                'value' => '152',
                'type' => 'string',
                'description' => 'ID Kota asal pengiriman (RajaOngkir)',
                'group' => 'shipping'
            ],
            [
                'key' => 'shipping_origin_district_id',
                'value' => '1391',
                'type' => 'string',
                'description' => 'ID Kecamatan asal pengiriman (RajaOngkir)',
                'group' => 'shipping'
            ],
            [
                'key' => 'shipping_origin_province_name',
                'value' => 'DKI Jakarta',
                'type' => 'string',
                'description' => 'Nama Provinsi asal pengiriman',
                'group' => 'shipping'
            ],
            [
                'key' => 'shipping_origin_city_name',
                'value' => 'Jakarta Barat',
                'type' => 'string',
                'description' => 'Nama Kota asal pengiriman',
                'group' => 'shipping'
            ],
            [
                'key' => 'shipping_origin_district_name',
                'value' => 'Kebon Jeruk',
                'type' => 'string',
                'description' => 'Nama Kecamatan asal pengiriman',
                'group' => 'shipping'
            ],
            [
                'key' => 'default_product_weight',
                'value' => '300',
                'type' => 'integer',
                'description' => 'Berat default produk dalam gram',
                'group' => 'shipping'
            ],

            // Payment Settings
            [
                'key' => 'bank_account_name',
                'value' => 'Aneka Sandal',
                'type' => 'string',
                'description' => 'Nama pemilik rekening bank',
                'group' => 'payment'
            ],
            [
                'key' => 'bank_account_number',
                'value' => '1234567890',
                'type' => 'string',
                'description' => 'Nomor rekening bank',
                'group' => 'payment'
            ],
            [
                'key' => 'bank_name',
                'value' => 'Bank BCA',
                'type' => 'string',
                'description' => 'Nama bank',
                'group' => 'payment'
            ]
        ];

        foreach ($settings as $setting) {
            StoreSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
