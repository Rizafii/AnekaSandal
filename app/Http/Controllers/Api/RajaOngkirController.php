<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class RajaOngkirController extends Controller
{
    private $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }

    /**
     * Get all provinces
     */
    public function getProvinces(): JsonResponse
    {
        $provinces = $this->rajaOngkirService->getProvinces();
        return response()->json($provinces);
    }

    /**
     * Get cities by province ID
     */
    public function getCities($provinceId): JsonResponse
    {
        $cities = $this->rajaOngkirService->getCities($provinceId);
        return response()->json($cities);
    }

    /**
     * Get districts by city ID
     */
    public function getDistricts($cityId): JsonResponse
    {
        $districts = $this->rajaOngkirService->getDistricts($cityId);
        return response()->json($districts);
    }

    /**
     * Get shipping cost
     */
    public function getShippingCost(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'origin' => 'required|string',
                'destination' => 'required|string',
                'weight' => 'required|integer|min:1',
                'courier' => 'required|string'
            ]);

            Log::info('Shipping cost request received', [
                'origin' => $request->origin,
                'destination' => $request->destination,
                'weight' => $request->weight,
                'courier' => $request->courier
            ]);

            $shippingCosts = $this->rajaOngkirService->getShippingCost(
                $request->origin,
                $request->destination,
                $request->weight,
                $request->courier
            );

            return response()->json([
                'success' => true,
                'data' => $shippingCosts
            ]);
        } catch (\Exception $e) {
            Log::error('Shipping cost calculation failed', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate shipping cost',
                'error' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Get city details by ID
     */
    public function getCity($cityId): JsonResponse
    {
        $city = $this->rajaOngkirService->getCity($cityId);

        if (!$city) {
            return response()->json(['error' => 'City not found'], 404);
        }

        return response()->json($city);
    }

    /**
     * Get district details by ID
     */
    public function getDistrict($districtId): JsonResponse
    {
        $district = $this->rajaOngkirService->getDistrict($districtId);

        if (!$district) {
            return response()->json(['error' => 'District not found'], 404);
        }

        return response()->json($district);
    }

    /**
     * Get province details by ID
     */
    public function getProvince($provinceId): JsonResponse
    {
        $province = $this->rajaOngkirService->getProvince($provinceId);

        if (!$province) {
            return response()->json(['error' => 'Province not found'], 404);
        }

        return response()->json($province);
    }
}
