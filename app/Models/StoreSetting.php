<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'description',
        'type',
        'group'
    ];

    // Add casts for better type handling
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get a setting value by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        // Convert value based on type
        return self::convertValue($setting->value, $setting->type);
    }

    /**
     * Set a setting value
     * 
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @param string|null $description
     * @param string $group
     * @return static
     */
    public static function set($key, $value, $type = 'string', $description = null, $group = 'general')
    {
        // Convert complex types to string for storage
        if (in_array($type, ['array', 'json']) && is_array($value)) {
            $value = json_encode($value);
        }

        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description,
                'group' => $group
            ]
        );
    }

    /**
     * Convert value based on type
     * 
     * @param string|null $value
     * @param string $type
     * @return mixed
     */
    private static function convertValue($value, $type)
    {
        if ($value === null) {
            return null;
        }

        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'array':
            case 'json':
                $decoded = json_decode($value, true);
                return $decoded !== null ? $decoded : [];
            default:
                return (string) $value;
        }
    }

    /**
     * Get all settings grouped by group
     * 
     * @return array
     */
    public static function getAllGrouped()
    {
        $settings = self::all();

        return $settings->groupBy('group')->map(function ($group) {
            return $group->keyBy('key')->map(function ($setting) {
                // Convert each setting value based on its type
                return [
                    'key' => $setting->key,
                    'value' => self::convertValue($setting->value, $setting->type),
                    'raw_value' => $setting->value, // Keep raw value for form inputs
                    'type' => $setting->type,
                    'description' => $setting->description,
                    'group' => $setting->group,
                    'created_at' => $setting->created_at,
                    'updated_at' => $setting->updated_at,
                ];
            });
        })->toArray();
    }

    /**
     * Get multiple settings by keys
     * 
     * @param array $keys
     * @param array $defaults
     * @return array
     */
    public static function getMultiple(array $keys, array $defaults = [])
    {
        $settings = self::whereIn('key', $keys)->get()->keyBy('key');
        $result = [];

        foreach ($keys as $key) {
            if ($settings->has($key)) {
                $setting = $settings->get($key);
                $result[$key] = self::convertValue($setting->value, $setting->type);
            } else {
                $result[$key] = $defaults[$key] ?? null;
            }
        }

        return $result;
    }

    /**
     * Get shipping origin district ID
     * 
     * @return string|null
     */
    public static function getShippingOrigin()
    {
        return self::get('shipping_origin_district_id', '1391'); // Default Jakarta Barat
    }

    /**
     * Get all shipping origin info
     * 
     * @return array
     */
    public static function getShippingOriginInfo()
    {
        return self::getMultiple([
            'shipping_origin_district_id',
            'shipping_origin_district_name',
            'shipping_origin_city_id',
            'shipping_origin_city_name',
            'shipping_origin_province_id',
            'shipping_origin_province_name',
        ], [
            'shipping_origin_district_id' => '1391',
            'shipping_origin_district_name' => 'Jakarta Barat',
            'shipping_origin_city_id' => '152',
            'shipping_origin_city_name' => 'Kota Jakarta Barat',
            'shipping_origin_province_id' => '6',
            'shipping_origin_province_name' => 'DKI Jakarta',
        ]);
    }

    /**
     * Get store info
     * 
     * @return array
     */
    public static function getStoreInfo()
    {
        return self::getMultiple([
            'store_name',
            'store_address',
            'store_phone',
            'store_email',
        ], [
            'store_name' => 'Aneka Sandal',
            'store_address' => '',
            'store_phone' => '',
            'store_email' => '',
        ]);
    }

    /**
     * Get payment info
     * 
     * @return array
     */
    public static function getPaymentInfo()
    {
        return self::getMultiple([
            'bank_name',
            'bank_account_name',
            'bank_account_number',
        ], [
            'bank_name' => '',
            'bank_account_name' => '',
            'bank_account_number' => '',
        ]);
    }

    /**
     * Get store name
     * 
     * @return string
     */
    public static function getStoreName()
    {
        return self::get('store_name', 'Aneka Sandal');
    }

    /**
     * Get store address
     * 
     * @return string
     */
    public static function getStoreAddress()
    {
        return self::get('store_address', '');
    }

    /**
     * Get store phone
     * 
     * @return string
     */
    public static function getStorePhone()
    {
        return self::get('store_phone', '');
    }

    /**
     * Get default product weight
     * 
     * @return int
     */
    public static function getDefaultProductWeight()
    {
        return self::get('default_product_weight', 300);
    }

    /**
     * Check if a setting exists
     * 
     * @param string $key
     * @return bool
     */
    public static function has($key)
    {
        return self::where('key', $key)->exists();
    }

    /**
     * Delete a setting by key
     * 
     * @param string $key
     * @return bool
     */
    public static function forget($key)
    {
        return self::where('key', $key)->delete();
    }

    /**
     * Get settings by group
     * 
     * @param string $group
     * @return array
     */
    public static function getByGroup($group)
    {
        return self::where('group', $group)
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => self::convertValue($setting->value, $setting->type)];
            })
            ->toArray();
    }
}