<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RajaOngkirController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Raja Ongkir API Routes
Route::prefix('rajaongkir')->group(function () {
    Route::get('/provinces', [RajaOngkirController::class, 'getProvinces']);
    Route::get('/cities/{provinceId}', [RajaOngkirController::class, 'getCities']);
    Route::get('/districts/{cityId}', [RajaOngkirController::class, 'getDistricts']);
    Route::post('/shipping-cost', [RajaOngkirController::class, 'getShippingCost']);
    Route::get('/city/{cityId}', [RajaOngkirController::class, 'getCity']);
    Route::get('/province/{provinceId}', [RajaOngkirController::class, 'getProvince']);
    Route::get('/district/{districtId}', [RajaOngkirController::class, 'getDistrict']);
});
