<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TrackingService
{
    private $rajaongkirUrl;
    private $rajaongkirApiKey;
    private $binderbyteUrl;
    private $binderbyteApiKey;

    public function __construct()
    {
        $this->rajaongkirUrl = config('services.rajaongkir.url');
        $this->rajaongkirApiKey = config('services.rajaongkir.api_key');
        $this->binderbyteUrl = config('services.binderbyte.url');
        $this->binderbyteApiKey = config('services.binderbyte.api_key');
    }

    /**
     * Track shipment with fallback mechanism
     * 
     * @param string $courier
     * @param string $awb
     * @return array
     */
    public function track($courier, $awb)
    {
        // Convert courier to lowercase
        $courier = strtolower($courier);

        // Try RajaOngkir first
        $rajaongkirResult = $this->trackWithRajaOngkir($courier, $awb);

        if ($rajaongkirResult['success']) {
            return $rajaongkirResult;
        }

        // Fallback to BinderByte
        Log::info('RajaOngkir failed, trying BinderByte', [
            'courier' => $courier,
            'awb' => $awb,
            'rajaongkir_error' => $rajaongkirResult['message'] ?? 'Unknown error'
        ]);

        return $this->trackWithBinderByte($courier, $awb);
    }

    /**
     * Track using RajaOngkir API
     * 
     * @param string $courier
     * @param string $awb
     * @return array
     */
    private function trackWithRajaOngkir($courier, $awb)
    {
        try {
            // Validate courier for RajaOngkir (only JNE, JNT, POS supported)
            $validCouriers = ['jne', 'jnt', 'pos'];
            if (!in_array($courier, $validCouriers)) {
                return [
                    'success' => false,
                    'message' => 'Kurir tidak didukung oleh RajaOngkir',
                    'source' => 'rajaongkir'
                ];
            }
            $url = "{$this->rajaongkirUrl}/track/waybill?awb={$awb}&courier={$courier}";

            $response = Http::withHeaders([
                'key' => $this->rajaongkirApiKey
            ])->post($url);




            if ($response->successful()) {
                $data = $response->json();
                // Check if tracking data exists
                if (isset($data['data'])) {
                    return [
                        'success' => true,
                        'data' => $this->formatRajaOngkirData($data['data']),
                        'source' => 'rajaongkir',
                        'raw' => $data
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Data tracking tidak ditemukan dari RajaOngkir',
                    'source' => 'rajaongkir',
                    'raw_response' => $data
                ];
            }

            $errorBody = $response->body();
            Log::error('RajaOngkir API error response', [
                'status' => $response->status(),
                'body' => $errorBody
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menghubungi RajaOngkir API (HTTP ' . $response->status() . ')',
                'source' => 'rajaongkir',
                'status_code' => $response->status(),
                'error_body' => $errorBody
            ];
        } catch (\Exception $e) {
            Log::error('RajaOngkir tracking error', [
                'courier' => $courier,
                'awb' => $awb,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'source' => 'rajaongkir'
            ];
        }
    }

    /**
     * Track using BinderByte API
     * 
     * @param string $courier
     * @param string $awb
     * @return array
     */
    private function trackWithBinderByte($courier, $awb)
    {
        try {
            $response = Http::timeout(30)->get($this->binderbyteUrl, [
                'api_key' => $this->binderbyteApiKey,
                'courier' => $courier,
                'awb' => $awb
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Check if tracking data exists
                if (isset($data['data']) && isset($data['status']) && $data['status'] == 200) {
                    return [
                        'success' => true,
                        'data' => $this->formatBinderByteData($data['data']),
                        'source' => 'binderbyte',
                        'raw' => $data
                    ];
                }

                return [
                    'success' => false,
                    'message' => $data['message'] ?? 'Data tracking tidak ditemukan',
                    'source' => 'binderbyte',
                    'raw_response' => $data
                ];
            }

            $errorBody = $response->body();
            Log::error('BinderByte API error response', [
                'status' => $response->status(),
                'body' => $errorBody
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menghubungi BinderByte API (HTTP ' . $response->status() . ')',
                'source' => 'binderbyte',
                'status_code' => $response->status(),
                'error_body' => $errorBody
            ];
        } catch (\Exception $e) {
            Log::error('BinderByte tracking error', [
                'courier' => $courier,
                'awb' => $awb,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'source' => 'binderbyte'
            ];
        }
    }

    /**
     * Format RajaOngkir tracking data to standard format
     * 
     * @param array $data
     * @return array
     */
    private function formatRajaOngkirData($data)
    {
        return [
            'waybill' => $data['waybill_number'] ?? '',
            'courier' => strtoupper($data['courier_code'] ?? ''),
            'service' => $data['service_code'] ?? '',
            'status' => [
                'code' => $data['delivery_status']['status'] ?? '',
                'description' => $data['delivery_status']['status'] ?? 'Dalam proses pengiriman'
            ],
            'shipper' => [
                'name' => $data['shipper_name'] ?? '',
                'address' => $data['origin'] ?? ''
            ],
            'receiver' => [
                'name' => $data['receiver_name'] ?? '',
                'address' => $data['destination'] ?? ''
            ],
            'history' => $this->formatRajaOngkirHistory($data['manifest'] ?? [])
        ];
    }

    /**
     * Format RajaOngkir history
     * 
     * @param array $manifest
     * @return array
     */
    private function formatRajaOngkirHistory($manifest)
    {
        $history = [];

        foreach ($manifest as $item) {
            $history[] = [
                'date' => $item['manifest_date'] ?? '',
                'time' => $item['manifest_time'] ?? '',
                'description' => $item['manifest_description'] ?? '',
                'location' => $item['city_name'] ?? ''
            ];
        }

        return $history;
    }

    /**
     * Format BinderByte tracking data to standard format
     * 
     * @param array $data
     * @return array
     */
    private function formatBinderByteData($data)
    {
        return [
            'waybill' => $data['summary']['awb'] ?? '',
            'courier' => strtoupper($data['summary']['courier'] ?? ''),
            'service' => $data['summary']['service'] ?? '',
            'status' => [
                'code' => $data['summary']['status'] ?? '',
                'description' => $data['summary']['status'] ?? 'Dalam proses pengiriman'
            ],
            'shipper' => [
                'name' => $data['detail']['shipper'] ?? '',
                'address' => $data['detail']['origin'] ?? ''
            ],
            'receiver' => [
                'name' => $data['detail']['receiver'] ?? '',
                'address' => $data['detail']['destination'] ?? ''
            ],
            'history' => $this->formatBinderByteHistory($data['history'] ?? [])
        ];
    }

    /**
     * Format BinderByte history
     * 
     * @param array $history
     * @return array
     */
    private function formatBinderByteHistory($history)
    {
        $formatted = [];

        foreach ($history as $item) {
            $formatted[] = [
                'date' => $item['date'] ?? '',
                'time' => '',
                'description' => $item['desc'] ?? '',
                'location' => $item['location'] ?? ''
            ];
        }

        return $formatted;
    }

    /**
     * Check if tracking status indicates delivery is complete
     * 
     * @param string $statusDescription
     * @return bool
     */
    public function isDelivered($statusDescription)
    {
        $statusDescription = strtolower($statusDescription);

        $deliveredKeywords = [
            'delivered',
            'terkirim',
            'diterima',
            'selesai',
            'delivered to',
            'shipment delivered',
            'paket diterima',
            'paket telah diterima',
            'telah diterima'
        ];

        foreach ($deliveredKeywords as $keyword) {
            if (strpos($statusDescription, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }
}
