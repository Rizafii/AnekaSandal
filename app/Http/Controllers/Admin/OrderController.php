<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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

    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('full_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load([
            'user',
            'items.product.images',
            'items.variant',
            'statusLogs.changedBy'
        ]);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:menunggu_pembayaran,sedang_dikirm,selesai,dibatalkan',
            'notes' => 'nullable|string'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update([
            'status' => $newStatus
        ]);

        // Log status change
        $order->addStatusLog($newStatus, $request->notes, Auth::id());

        return back()->with('success', "Status pesanan berhasil diubah dari {$oldStatus} ke {$newStatus}");
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:belum_bayar,menunggu_konfirmasi,terkonfirmasi,ditolak',
            'notes' => 'nullable|string'
        ]);

        $oldPaymentStatus = $order->payment_status;
        $newPaymentStatus = $request->payment_status;

        $order->update([
            'payment_status' => $newPaymentStatus
        ]);

        // If payment is confirmed, automatically update order status
        if ($newPaymentStatus === Order::PAYMENT_STATUS_TERKONFIRMASI && $order->status === Order::STATUS_MENUNGGU_PEMBAYARAN) {
            $order->update(['status' => Order::STATUS_SEDANG_DIKIRIM]);
            $order->addStatusLog(Order::STATUS_SEDANG_DIKIRIM, 'Status otomatis diubah karena pembayaran dikonfirmasi', Auth::id());
        }

        // Log payment status change
        $order->addStatusLog($newPaymentStatus, $request->notes, Auth::id());

        return back()->with('success', "Status pembayaran berhasil diubah dari {$oldPaymentStatus} ke {$newPaymentStatus}");
    }

    public function uploadShippingProof(Request $request, Order $order)
    {
        $request->validate([
            'shipping_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tracking_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string'
        ]);

        if ($request->hasFile('shipping_proof')) {
            $file = $request->file('shipping_proof');
            $filename = 'shipping_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('shipping_proofs', $filename, 'public');

            $updateData = [
                'status' => Order::STATUS_SEDANG_DIKIRIM,
                'shipped_at' => now(),
                'notes' => ($order->notes ? $order->notes . "\n" : '') . 'Bukti pengiriman: ' . $path
            ];

            if ($request->tracking_number) {
                $updateData['tracking_number'] = $request->tracking_number;
            }

            $order->update($updateData);

            $order->addStatusLog(Order::STATUS_SEDANG_DIKIRIM, $request->notes ?: 'Bukti pengiriman diunggah', Auth::id());

            return back()->with('success', 'Bukti pengiriman berhasil diunggah dan status pesanan diubah ke Sedang Dikirim');
        }

        return back()->with('error', 'Gagal mengunggah bukti pengiriman');
    }
}
