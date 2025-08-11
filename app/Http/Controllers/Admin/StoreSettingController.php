<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StoreSettingController extends Controller
{

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

            return redirect()->route('admin.store-settings.index')
                ->with('success', 'Pengaturan toko berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Error updating store settings: ' . $e->getMessage());

            return redirect()->route('admin.store-settings.index')
                ->with('error', 'Gagal memperbarui pengaturan toko: ' . $e->getMessage());
        }
    }
}