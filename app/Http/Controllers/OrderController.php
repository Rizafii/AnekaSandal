<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\TrackingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::with(['items.product', 'statusLogs'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load(['items.product.images', 'items.variant', 'statusLogs.changedBy']);

        return view('orders.show', compact('order'));
    }

    public function confirmReceived(Request $request, Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($order->status !== Order::STATUS_SEDANG_DIKIRIM) {
            return back()->with('error', 'Status pesanan tidak valid untuk konfirmasi penerimaan');
        }

        $request->validate([
            'delivery_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'delivery_proof.required' => 'Bukti penerimaan harus diunggah',
            'delivery_proof.image' => 'File harus berupa gambar',
            'delivery_proof.mimes' => 'Format file harus JPEG, PNG, atau JPG',
            'delivery_proof.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            if ($request->hasFile('delivery_proof')) {
                $file = $request->file('delivery_proof');
                $filename = 'delivery_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('delivery_proofs', $filename, 'public');

                $order->update([
                    'status' => Order::STATUS_SELESAI,
                    'delivered_at' => now(),
                    'notes' => ($order->notes ? $order->notes . "\n" : '') . 'Bukti penerimaan: ' . $path
                ]);

                $order->addStatusLog(Order::STATUS_SELESAI, 'Pesanan diterima oleh customer');

                return redirect()->route('orders.show', $order->id)
                    ->with('success', 'Terima kasih! Pesanan telah dikonfirmasi diterima.');
            }

            return back()->with('error', 'Gagal mengunggah bukti penerimaan');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan');
        }

        try {
            // Restore stock if order items have variants
            foreach ($order->items as $item) {
                if ($item->variant) {
                    $item->variant->increment('stock', $item->quantity);
                }
            }

            $order->update([
                'status' => Order::STATUS_DIBATALKAN
            ]);

            $order->addStatusLog(Order::STATUS_DIBATALKAN, 'Pesanan dibatalkan oleh customer');

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dibatalkan');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Track shipment via API
     */
    public function trackShipment(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            // Check if user owns this order
            if ($order->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            if (!$order->tracking_number || !$order->courier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor resi atau kurir tidak tersedia'
                ], 400);
            }

            $trackingService = new TrackingService();
            $result = $trackingService->track($order->courier, $order->tracking_number);

            return response()->json($result);

        } catch (\Exception $e) {
            \Log::error('Error tracking shipment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
