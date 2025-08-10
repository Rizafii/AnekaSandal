<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StoreSettingController extends Controller
{
    protected $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }

    /**
     * Display store settings page
     */
    public function index()
    {
        $settings = StoreSetting::getAllGrouped();

        return view('admin.store-settings.index', compact('settings'));
    }

    /**
     * Update store settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string',
            'store_phone' => 'required|string|max:20',
            'store_email' => 'required|email|max:255',
            'shipping_origin_district_id' => 'nullable|string', // Changed to nullable
            'default_product_weight' => 'required|integer|min:1',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
            'bank_name' => 'required|string|max:255',
        ]);

        try {
            // Define mapping for type and group, then perform a single upsert (replace-like)
            $settingsMap = [
                // Store info
                'store_name' => ['type' => 'string', 'group' => 'store_info'],
                'store_address' => ['type' => 'string', 'group' => 'store_info'],
                'store_phone' => ['type' => 'string', 'group' => 'store_info'],
                'store_email' => ['type' => 'string', 'group' => 'store_info'],
                // Shipping
                'shipping_origin_district_id' => ['type' => 'string', 'group' => 'shipping'],
                'default_product_weight' => ['type' => 'integer', 'group' => 'shipping'],
                // Payment
                'bank_account_name' => ['type' => 'string', 'group' => 'payment'],
                'bank_account_number' => ['type' => 'string', 'group' => 'payment'],
                'bank_name' => ['type' => 'string', 'group' => 'payment'],
            ];

            $rows = [];
            foreach ($settingsMap as $key => $meta) {
                if ($request->has($key)) {
                    $value = $request->input($key);
                    if ($meta['type'] === 'integer') {
                        $value = (int) $value;
                    }

                    // Skip empty shipping_origin_district_id
                    if ($key === 'shipping_origin_district_id' && empty($value)) {
                        continue;
                    }

                    $rows[] = [
                        'key' => $key,
                        'value' => $value,
                        'type' => $meta['type'],
                        'description' => null,
                        'group' => $meta['group'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($rows)) {
                // Upsert by unique 'key' column; updates value/type/group/description
                DB::table('store_settings')->upsert(
                    $rows,
                    ['key'],
                    ['value', 'type', 'group', 'description', 'updated_at']
                );
            }

            // If district ID changed, update related location names
            if ($request->has('shipping_origin_district_id') && !empty($request->shipping_origin_district_id)) {
                $this->updateShippingLocationNames($request->shipping_origin_district_id);
            }

            return redirect()->route('admin.store-settings.index')
                ->with('success', 'Pengaturan toko berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Error updating store settings: ' . $e->getMessage());

            return redirect()->route('admin.store-settings.index')
                ->with('error', 'Gagal memperbarui pengaturan toko: ' . $e->getMessage());
        }
    }

    /**
     * Get provinces for shipping origin selection
     */
    public function getProvinces()
    {
        try {
            $provinces = $this->rajaOngkirService->getProvinces();
            return response()->json(['success' => true, 'data' => $provinces]);
        } catch (\Exception $e) {
            Log::error('Error fetching provinces: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memuat provinsi']);
        }
    }

    /**
     * Get cities by province ID
     */
    public function getCities($provinceId)
    {
        try {
            $cities = $this->rajaOngkirService->getCities($provinceId);
            return response()->json(['success' => true, 'data' => $cities]);
        } catch (\Exception $e) {
            Log::error('Error fetching cities: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memuat kota']);
        }
    }

    /**
     * Get districts by city ID
     */
    public function getDistricts($cityId)
    {
        try {
            $districts = $this->rajaOngkirService->getDistricts($cityId);
            return response()->json(['success' => true, 'data' => $districts]);
        } catch (\Exception $e) {
            Log::error('Error fetching districts: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memuat kecamatan']);
        }
    }

    /**
     * Update shipping location names based on district ID
     */
    private function updateShippingLocationNames($districtId)
    {
        try {
            // Get district info from RajaOngkir
            $district = $this->rajaOngkirService->getDistrict($districtId);

            if ($district) {
                // Update district name
                StoreSetting::set('shipping_origin_district_name', $district['district_name'], 'string', 'Nama Kecamatan asal pengiriman', 'shipping');

                // Update city info
                if (isset($district['city_id'])) {
                    $city = $this->rajaOngkirService->getCity($district['city_id']);
                    if ($city) {
                        StoreSetting::set('shipping_origin_city_id', $city['city_id'], 'string', 'ID Kota asal pengiriman (RajaOngkir)', 'shipping');
                        StoreSetting::set('shipping_origin_city_name', $city['type'] . ' ' . $city['city_name'], 'string', 'Nama Kota asal pengiriman', 'shipping');

                        // Update province info
                        if (isset($city['province_id'])) {
                            $province = $this->rajaOngkirService->getProvince($city['province_id']);
                            if ($province) {
                                StoreSetting::set('shipping_origin_province_id', $province['province_id'], 'string', 'ID Provinsi asal pengiriman (RajaOngkir)', 'shipping');
                                StoreSetting::set('shipping_origin_province_name', $province['province'], 'string', 'Nama Provinsi asal pengiriman', 'shipping');
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error updating shipping location names: ' . $e->getMessage());
        }
    }
}