<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\StoreSettingController;
use App\Http\Controllers\Api\RajaOngkirController;

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/promos', [HomeController::class, 'promos'])->name('promos');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Password Reset Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

// Category Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.products');

// Cart Routes (Authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/buy-now', [CartController::class, 'buyNow'])->name('buy.now');

    // Profile Route
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});

// Order routes
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/confirm-received', [OrderController::class, 'confirmReceived'])->name('orders.confirm.received');
    Route::get('/orders/{id}/track', [OrderController::class, 'trackShipment'])->name('orders.track');
});

// Testimonial routes
Route::middleware('auth')->group(function () {
    Route::get('/testimonials/create', [\App\Http\Controllers\TestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('/testimonials', [\App\Http\Controllers\TestimonialController::class, 'store'])->name('testimonials.store');
});

// Checkout routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/payment/{order}/upload', [CheckoutController::class, 'uploadPayment'])->name('checkout.upload.payment');
});

// Shipping API routes (public for location data)
Route::prefix('api')->group(function () {
    Route::get('/rajaongkir/provinces', [RajaOngkirController::class, 'getProvinces'])->name('api.rajaongkir.provinces');
    Route::get('/rajaongkir/cities/{provinceId}', [RajaOngkirController::class, 'getCities'])->name('api.rajaongkir.cities');
    Route::get('/rajaongkir/districts/{cityId}', [RajaOngkirController::class, 'getDistricts'])->name('api.rajaongkir.districts');
    Route::post('/rajaongkir/shipping-cost', [RajaOngkirController::class, 'getShippingCost'])->name('api.rajaongkir.shipping.cost');
    Route::get('/rajaongkir/city/{cityId}', [RajaOngkirController::class, 'getCity'])->name('api.rajaongkir.city');
    Route::get('/rajaongkir/province/{provinceId}', [RajaOngkirController::class, 'getProvince'])->name('api.rajaongkir.province');
    Route::get('/rajaongkir/district/{districtId}', [RajaOngkirController::class, 'getDistrict'])->name('api.rajaongkir.district');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Category Management
    Route::resource('categories', AdminCategoryController::class);

    // Admin Product Management
    Route::resource('products', AdminProductController::class);
    Route::patch('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');

    // AJAX endpoint for quick category creation
    Route::post('/categories/quick-create', [AdminCategoryController::class, 'quickCreate'])->name('categories.quick-create');

    // Admin Order Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('/orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
    Route::post('/orders/{order}/shipping-proof', [AdminOrderController::class, 'uploadShippingProof'])->name('orders.upload-shipping-proof');
    Route::patch('/orders/{order}/ship', [AdminOrderController::class, 'ship'])->name('orders.ship');
    Route::post('/orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{id}/track', [AdminOrderController::class, 'trackShipment'])->name('orders.track');

    // Admin Store Settings
    Route::get('/store-settings', [StoreSettingController::class, 'index'])->name('store-settings.index');
    Route::put('/store-settings', [StoreSettingController::class, 'update'])->name('store-settings.update');
});
