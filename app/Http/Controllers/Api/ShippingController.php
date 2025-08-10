<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    public function getProvinces()
    {
        $provinces = $this->shippingService->getProvinces();
        return response()->json($provinces);
    }

    public function getCities(Request $request)
    {
        $provinceId = $request->get('province_id');
        $cities = $this->shippingService->getCities($provinceId);
        return response()->json($cities);
    }

    public function calculateCost(Request $request)
    {
        $request->validate([
            'destination' => 'required|integer',
            'weight' => 'required|integer|min:1',
            'courier' => 'required|string|in:jne,pos,tiki'
        ]);

        $origin = $this->shippingService->getDefaultOriginCity();
        $costs = $this->shippingService->calculateShippingCost(
            $origin,
            $request->destination,
            $request->weight,
            $request->courier
        );

        return response()->json($costs);
    }
}
