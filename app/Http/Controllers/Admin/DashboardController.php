<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Products;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', Order::STATUS_MENUNGGU_PEMBAYARAN)->count(),
            'shipping_orders' => Order::where('status', Order::STATUS_SEDANG_DIKIRIM)->count(),
            'completed_orders' => Order::where('status', Order::STATUS_SELESAI)->count(),
            'total_revenue' => Order::where('status', Order::STATUS_SELESAI)->sum('final_amount'),
            'pending_payments' => Order::where('payment_status', Order::PAYMENT_STATUS_MENUNGGU_KONFIRMASI)->count(),
            'total_products' => Products::count(),
            'active_products' => Products::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'active_categories' => Category::where('is_active', true)->count(),
            'total_customers' => User::where('role', 'customer')->count(),
        ];

        $recentOrders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Orders by status for charts
        $ordersByStatus = [
            'menunggu_pembayaran' => Order::where('status', Order::STATUS_MENUNGGU_PEMBAYARAN)->count(),
            'sedang_dikirim' => Order::where('status', Order::STATUS_SEDANG_DIKIRIM)->count(),
            'selesai' => Order::where('status', Order::STATUS_SELESAI)->count(),
            'dibatalkan' => Order::where('status', Order::STATUS_DIBATALKAN)->count(),
        ];

        return view('admin.dashboard', compact('stats', 'recentOrders', 'ordersByStatus'));
    }
}
