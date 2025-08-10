<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShippingService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.key');
        $this->baseUrl = config('services.rajaongkir.url');
    }

    public function getProvinces()
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/province");

            if ($response->successful()) {
                return $response->json()['rajaongkir']['results'];
            }

            Log::error('RajaOngkir API Error - Get Provinces', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir Exception - Get Provinces', [
                'message' => $e->getMessage()
            ]);
            return [];
        }
    }

    public function getCities($provinceId = null)
    {
        try {
            $url = "{$this->baseUrl}/city";
            if ($provinceId) {
                $url .= "?province={$provinceId}";
            }

            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->get($url);

            if ($response->successful()) {
                return $response->json()['rajaongkir']['results'];
            }

            Log::error('RajaOngkir API Error - Get Cities', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir Exception - Get Cities', [
                'message' => $e->getMessage()
            ]);
            return [];
        }
    }

    public function calculateShippingCost($origin, $destination, $weight, $courier = 'jne')
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey,
                'content-type' => 'application/x-www-form-urlencoded'
            ])->asForm()->post("{$this->baseUrl}/cost", [
                        'origin' => $origin,
                        'destination' => $destination,
                        'weight' => $weight,
                        'courier' => $courier
                    ]);

            if ($response->successful()) {
                $data = $response->json()['rajaongkir'];

                if ($data['status']['code'] === 200) {
                    return $data['results'][0]['costs'] ?? [];
                }
            }

            Log::error('RajaOngkir API Error - Calculate Cost', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir Exception - Calculate Cost', [
                'message' => $e->getMessage()
            ]);
            return [];
        }
    }

    public function getAvailableCouriers()
    {
        return [
            'jne' => 'JNE',
            'pos' => 'POS Indonesia',
            'tiki' => 'TIKI'
        ];
    }

    public function getDefaultOriginCity()
    {
        // Get origin from store settings, default to Jakarta Barat if not set
        return \App\Models\StoreSetting::getShippingOrigin();
    }

    public function calculateProductWeight($items)
    {
        // Get default weight from store settings
        $defaultWeight = \App\Models\StoreSetting::get('default_product_weight', 300);
        $totalWeight = 0;

        foreach ($items as $item) {
            $weight = $item->product->weight ?? $defaultWeight;
            $totalWeight += $weight * $item->quantity;
        }

        // Convert to grams and ensure minimum weight
        return max($totalWeight, 100);
    }
}
