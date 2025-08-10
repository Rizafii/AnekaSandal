<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RajaOngkirService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.key');
        $this->baseUrl = config('services.rajaongkir.url');
    }

    /**
     * Get all provinces
     */
    public function getProvinces()
    {
        try {
            $url = $this->baseUrl . '/destination/province';
            Log::info('Making request to RajaOngkir provinces', [
                'url' => $url,
                'api_key' => substr($this->apiKey, 0, 10) . '...'
            ]);

            $response = Http::withHeaders([
                'Key' => $this->apiKey,
            ])->withOptions([
                        'verify' => false, // Disable SSL verification for local development
                    ])->get($url);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('RajaOngkir Provinces Response', [
                    'status' => $response->status(),
                    'has_data' => isset($data['data']),
                    'data_count' => isset($data['data']) ? count($data['data']) : 0,
                    'response_structure' => array_keys($data)
                ]);
                return $data['data'] ?? [];
            }

            Log::error('RajaOngkir API Error - Provinces', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir Exception - Provinces', [
                'message' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Get cities by province ID
     */
    public function getCities($provinceId)
    {
        try {
            $url = $this->baseUrl . '/destination/city/' . $provinceId;
            Log::info('Making request to RajaOngkir cities', [
                'url' => $url,
                'province_id' => $provinceId
            ]);

            $response = Http::withHeaders([
                'Key' => $this->apiKey,
            ])->withOptions([
                        'verify' => false, // Disable SSL verification for local development
                    ])->get($url);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('RajaOngkir Cities Response', [
                    'status' => $response->status(),
                    'has_data' => isset($data['data']),
                    'data_count' => isset($data['data']) ? count($data['data']) : 0
                ]);
                return $data['data'] ?? [];
            }

            Log::error('RajaOngkir API Error - Cities', [
                'status' => $response->status(),
                'response' => $response->body(),
                'province_id' => $provinceId
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir Exception - Cities', [
                'message' => $e->getMessage(),
                'province_id' => $provinceId
            ]);
            return [];
        }
    }

    /**
     * Get districts by city ID
     */
    public function getDistricts($cityId)
    {
        try {
            $url = $this->baseUrl . '/destination/district/' . $cityId;
            Log::info('Making request to RajaOngkir districts', [
                'url' => $url,
                'city_id' => $cityId
            ]);

            $response = Http::withHeaders([
                'Key' => $this->apiKey,
            ])->withOptions([
                        'verify' => false, // Disable SSL verification for local development
                    ])->get($url);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('RajaOngkir Districts Response', [
                    'status' => $response->status(),
                    'has_data' => isset($data['data']),
                    'data_count' => isset($data['data']) ? count($data['data']) : 0
                ]);
                return $data['data'] ?? [];
            }

            Log::error('RajaOngkir API Error - Districts', [
                'status' => $response->status(),
                'response' => $response->body(),
                'city_id' => $cityId
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir Exception - Districts', [
                'message' => $e->getMessage(),
                'city_id' => $cityId
            ]);
            return [];
        }
    }

    /**
     * Get shipping cost using the correct API endpoint
     */
    public function getShippingCost($origin, $destination, $weight, $courier)
    {
        try {
            // Prepare courier string - if it's an array, join with colon
            if (is_array($courier)) {
                $courierString = implode(':', $courier);
            } else {
                $courierString = $courier;
            }

            $url = $this->baseUrl . '/calculate/district/domestic-cost';
            Log::info('Making shipping cost request', [
                'url' => $url,
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courierString,
                'api_key' => substr($this->apiKey, 0, 10) . '...'
            ]);

            $response = Http::withHeaders([
                'Key' => $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->withOptions([
                        'verify' => false, // Disable SSL verification for local development
                    ])->asForm()->post($url, [
                        'origin' => $origin,
                        'destination' => $destination,
                        'weight' => $weight,
                        'courier' => $courierString,
                        'price' => 'lowest'
                    ]);

            if ($response->successful()) {
                $data = $response->json();

                Log::info('RajaOngkir API Response', [
                    'status' => $response->status(),
                    'has_data' => isset($data['data']),
                    'data_count' => isset($data['data']) ? count($data['data']) : 0
                ]);

                // Transform the response to group by courier
                $rawServices = $data['data'] ?? [];
                $groupedServices = [];

                foreach ($rawServices as $service) {
                    $courierCode = $service['code'];
                    $courierName = $service['name'];

                    if (!isset($groupedServices[$courierCode])) {
                        $groupedServices[$courierCode] = [
                            'code' => $courierCode,
                            'name' => $courierName,
                            'costs' => []
                        ];
                    }

                    $groupedServices[$courierCode]['costs'][] = [
                        'service' => $service['service'],
                        'description' => $service['description'],
                        'cost' => [
                            [
                                'value' => $service['cost'],
                                'etd' => $service['etd']
                            ]
                        ]
                    ];
                }

                return array_values($groupedServices);
            }

            Log::error('RajaOngkir API Error - Shipping Cost', [
                'status' => $response->status(),
                'response' => $response->body(),
                'params' => compact('origin', 'destination', 'weight', 'courierString')
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir Exception - Shipping Cost', [
                'message' => $e->getMessage(),
                'params' => compact('origin', 'destination', 'weight', 'courier')
            ]);
            return [];
        }
    }

    /**
     * Get city by ID
     */
    public function getCity($cityId)
    {
        try {
            $response = Http::withHeaders([
                'Key' => $this->apiKey,
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$cityId}");

            if ($response->successful()) {
                $data = $response->json();
                $results = $data['data'] ?? [];
                return count($results) > 0 ? $results[0] : null;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('RajaOngkir Exception - Get City', [
                'message' => $e->getMessage(),
                'city_id' => $cityId
            ]);
            return null;
        }
    }

    /**
     * Get province by ID
     */
    public function getProvince($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'Key' => $this->apiKey,
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/province");

            if ($response->successful()) {
                $data = $response->json();
                $results = $data['data'] ?? [];
                foreach ($results as $province) {
                    if ($province['id'] == $provinceId) {
                        return $province;
                    }
                }
            }

            return null;
        } catch (\Exception $e) {
            Log::error('RajaOngkir Exception - Get Province', [
                'message' => $e->getMessage(),
                'province_id' => $provinceId
            ]);
            return null;
        }
    }

    /**
     * Get district by ID
     */
    public function getDistrict($districtId)
    {
        try {
            // Note: This endpoint might need the city ID, but we'll try with district ID first
            $response = Http::withHeaders([
                'Key' => $this->apiKey,
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$districtId}");

            if ($response->successful()) {
                $data = $response->json();
                $results = $data['data'] ?? [];
                foreach ($results as $district) {
                    if ($district['id'] == $districtId) {
                        return $district;
                    }
                }
            }

            return null;
        } catch (\Exception $e) {
            Log::error('RajaOngkir Exception - Get District', [
                'message' => $e->getMessage(),
                'district_id' => $districtId
            ]);
            return null;
        }
    }
}
