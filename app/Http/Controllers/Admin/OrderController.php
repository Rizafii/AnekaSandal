<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'status' => 'required|in:menunggu_pembayaran,sedang_dikirim,selesai,dibatalkan',
            'notes' => 'nullable|string'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Additional validation for status transitions
        if ($oldStatus === 'selesai' && $newStatus !== 'selesai') {
            return back()->with('error', 'Pesanan yang sudah selesai tidak dapat diubah statusnya.');
        }

        if ($oldStatus === 'dibatalkan' && $newStatus !== 'dibatalkan') {
            return back()->with('error', 'Pesanan yang sudah dibatalkan tidak dapat diubah statusnya.');
        }

        $updateData = ['status' => $newStatus];

        // If marking as completed, set delivered_at timestamp
        if ($newStatus === Order::STATUS_SELESAI && $oldStatus !== Order::STATUS_SELESAI) {
            $updateData['delivered_at'] = now();
        }

        $order->update($updateData);

        // Log status change
        $notes = $request->notes;
        if ($newStatus === Order::STATUS_SELESAI && $oldStatus === Order::STATUS_SEDANG_DIKIRIM) {
            $notes = $notes ? $notes : 'Pesanan ditandai selesai oleh admin';
        }

        $order->addStatusLog($newStatus, $notes, Auth::id());

        $statusLabels = [
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'sedang_dikirim' => 'Sedang Dikirim',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];

        $oldStatusLabel = $statusLabels[$oldStatus] ?? $oldStatus;
        $newStatusLabel = $statusLabels[$newStatus] ?? $newStatus;

        return back()->with('success', "Status pesanan berhasil diubah dari {$oldStatusLabel} ke {$newStatusLabel}");
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

    public function ship(Request $request, Order $order)
    {
        $request->validate([
            'courier' => 'required|string|max:100',
            'tracking_number' => 'required|string|max:100',
            'shipped_at' => 'required|date',
            'shipping_image' => 'required|image|mimes:jpeg,png,jpg|max:10240', // 10MB max
            'notes' => 'nullable|string'
        ], [
            'courier.required' => 'Kurir harus diisi',
            'tracking_number.required' => 'Nomor resi harus diisi',
            'shipped_at.required' => 'Tanggal pengiriman harus diisi',
            'shipping_image.required' => 'Foto barang dikirim harus diunggah',
            'shipping_image.image' => 'File harus berupa gambar',
            'shipping_image.mimes' => 'Format file harus JPEG, PNG, atau JPG',
            'shipping_image.max' => 'Ukuran file maksimal 10MB'
        ]);

        try {
            // Handle file upload
            $shippingImagePath = null;
            if ($request->hasFile('shipping_image')) {
                $file = $request->file('shipping_image');
                $filename = 'shipping_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $shippingImagePath = $file->storeAs('shipping_images', $filename, 'public');
            }

            // Update order
            $updateData = [
                'status' => Order::STATUS_SEDANG_DIKIRIM,
                'courier' => $request->courier,
                'tracking_number' => $request->tracking_number,
                'shipped_at' => $request->shipped_at,
                'shipping_image' => $shippingImagePath,
                'notes' => $request->notes
            ];

            $order->update($updateData);

            // Add status log
            $order->addStatusLog(Order::STATUS_SEDANG_DIKIRIM, 'Pesanan dikirim dengan kurir: ' . $request->courier . ', No. Resi: ' . $request->tracking_number, auth()->id());

            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dikirim! Status pesanan telah diubah ke "Sedang Dikirim".');

        } catch (\Exception $e) {
            \Log::error('Error in ship method: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
