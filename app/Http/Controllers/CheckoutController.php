<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $items = collect();
        $total = 0;

        try {
            // Check if it's buy now or from cart
            if (session('buy_now')) {
                $buyNowData = session('buy_now');
                $product = Products::with(['images', 'variants'])->findOrFail($buyNowData['product_id']);
                $variant = null;

                if (!empty($buyNowData['variant_id'])) {
                    $variant = ProductVariant::findOrFail($buyNowData['variant_id']);

                    // Check stock availability
                    if ($variant->stock < $buyNowData['quantity']) {
                        session()->forget('buy_now');
                        return redirect()->route('products.show', $product->id)
                            ->with('error', 'Stok tidak mencukupi');
                    }
                }

                $price = $product->price + ($variant ? $variant->additional_price : 0);
                $subtotal = $price * $buyNowData['quantity'];

                $items->push((object) [
                    'id' => 'buy_now',
                    'product' => $product,
                    'variant' => $variant,
                    'quantity' => $buyNowData['quantity'],
                    'price' => $price,
                    'subtotal' => $subtotal
                ]);

                $total = $subtotal;
            } else {
                // Get selected cart items
                $selectedIds = $request->get('selected_items', []);
                if (empty($selectedIds)) {
                    return redirect()->route('cart.index')->with('error', 'Pilih item yang ingin di-checkout');
                }

                $cartItems = Cart::with(['product.images', 'variant'])
                    ->whereIn('id', $selectedIds)
                    ->where('user_id', Auth::id())
                    ->get();

                if ($cartItems->isEmpty()) {
                    return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan');
                }

                // Check stock for all items
                foreach ($cartItems as $item) {
                    if ($item->variant && $item->variant->stock < $item->quantity) {
                        return redirect()->route('cart.index')
                            ->with('error', "Stok {$item->product->name} tidak mencukupi");
                    }
                }

                foreach ($cartItems as $item) {
                    $items->push($item);
                    $total += $item->subtotal;
                }
            }

            if ($items->isEmpty()) {
                return redirect()->route('home')->with('error', 'Tidak ada item untuk checkout');
            }

            $shippingCost = 10000; // Default shipping cost
            $finalAmount = $total + $shippingCost;

            return view('checkout.index', compact('items', 'total', 'shippingCost', 'finalAmount'));

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        Log::info('Checkout store method called', $request->all());

        $request->validate([
            'shipping_name' => 'required|string|max:100',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:10',
        ]);

        DB::beginTransaction();
        try {
            $items = collect();
            $total = 0;

            // Get items again (same logic as index)
            if (session('buy_now')) {
                Log::info('Processing buy_now checkout');
                $buyNowData = session('buy_now');
                $product = Products::findOrFail($buyNowData['product_id']);
                $variant = null;

                if (!empty($buyNowData['variant_id'])) {
                    $variant = ProductVariant::findOrFail($buyNowData['variant_id']);

                    // Double check stock
                    if ($variant->stock < $buyNowData['quantity']) {
                        DB::rollback();
                        session()->forget('buy_now');
                        return redirect()->route('products.show', $product->id)
                            ->with('error', 'Stok tidak mencukupi');
                    }
                }

                $price = $product->price + ($variant ? $variant->additional_price : 0);
                $subtotal = $price * $buyNowData['quantity'];

                $items->push((object) [
                    'product' => $product,
                    'variant' => $variant,
                    'quantity' => $buyNowData['quantity'],
                    'price' => $price,
                    'subtotal' => $subtotal
                ]);

                $total = $subtotal;
            } else {
                Log::info('Processing cart checkout');
                $selectedIds = $request->get('selected_items', []);
                Log::info('Selected items:', $selectedIds);

                if (empty($selectedIds)) {
                    DB::rollback();
                    return redirect()->route('cart.index')->with('error', 'Pilih item yang ingin di-checkout');
                }

                $cartItems = Cart::with(['product', 'variant'])
                    ->whereIn('id', $selectedIds)
                    ->where('user_id', Auth::id())
                    ->get();

                Log::info('Found cart items:', $cartItems->toArray());

                if ($cartItems->isEmpty()) {
                    DB::rollback();
                    return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan di keranjang');
                }

                // Double check stock for all items
                foreach ($cartItems as $item) {
                    if ($item->variant && $item->variant->stock < $item->quantity) {
                        DB::rollback();
                        return redirect()->route('cart.index')
                            ->with('error', "Stok {$item->product->name} tidak mencukupi");
                    }
                }

                foreach ($cartItems as $item) {
                    $items->push($item);
                    $total += $item->subtotal;
                }
            }

            if ($items->isEmpty()) {
                DB::rollback();
                return redirect()->route('home')->with('error', 'Tidak ada item untuk checkout');
            }

            $shippingCost = 10000;
            $finalAmount = $total + $shippingCost;

            Log::info('Creating order with total:', ['total' => $total, 'final_amount' => $finalAmount]);

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => Order::STATUS_MENUNGGU_PEMBAYARAN,
                'total_amount' => $total,
                'shipping_cost' => $shippingCost,
                'final_amount' => $finalAmount,
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_postal_code' => $request->shipping_postal_code,
                'payment_status' => Order::PAYMENT_STATUS_BELUM_BAYAR
            ]);

            Log::info('Order created:', ['order_id' => $order->id, 'order_number' => $order->order_number]);

            // Create order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'variant_id' => $item->variant ? $item->variant->id : null,
                    'product_name' => $item->product->name,
                    'variant_info' => $item->variant ? "{$item->variant->size}" . ($item->variant->color ? " - {$item->variant->color}" : "") : null,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal
                ]);

                // Reduce stock
                if ($item->variant) {
                    $item->variant->decrement('stock', $item->quantity);
                }
            }

            // Log status
            $order->addStatusLog(Order::STATUS_MENUNGGU_PEMBAYARAN, 'Pesanan dibuat');

            // Clear cart if not buy now
            if (!session('buy_now')) {
                $selectedIds = $request->get('selected_items', []);
                Cart::whereIn('id', $selectedIds)->where('user_id', Auth::id())->delete();
                Log::info('Cart items deleted');
            } else {
                session()->forget('buy_now');
                Log::info('Buy now session cleared');
            }

            DB::commit();
            Log::info('Transaction committed successfully');

            return redirect()->route('checkout.payment', $order->id)
                ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout error:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function payment(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('checkout.payment', compact('order'));
    }

    public function uploadPayment(Request $request, Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if payment can be uploaded
        if (!$order->canUploadPayment()) {
            return back()->with('error', 'Tidak dapat mengunggah bukti pembayaran untuk pesanan ini');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'payment_proof.required' => 'Bukti pembayaran harus diunggah',
            'payment_proof.image' => 'File harus berupa gambar',
            'payment_proof.mimes' => 'Format file harus JPEG, PNG, atau JPG',
            'payment_proof.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            if ($request->hasFile('payment_proof')) {
                // Delete old payment proof if exists
                if ($order->payment_proof && Storage::disk('public')->exists($order->payment_proof)) {
                    Storage::disk('public')->delete($order->payment_proof);
                }

                $file = $request->file('payment_proof');
                $filename = 'payment_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('payment_proofs', $filename, 'public');

                $order->update([
                    'payment_proof' => $path,
                    'payment_status' => Order::PAYMENT_STATUS_MENUNGGU_KONFIRMASI
                ]);

                $order->addStatusLog(Order::PAYMENT_STATUS_MENUNGGU_KONFIRMASI, 'Bukti pembayaran diunggah');

                return back()->with('success', 'Bukti pembayaran berhasil diunggah. Silakan tunggu konfirmasi admin.');
            }

            return back()->with('error', 'Gagal mengunggah bukti pembayaran');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
