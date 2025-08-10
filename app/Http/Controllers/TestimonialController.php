<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show form to create testimonial for specific order item
     */
    public function create(Request $request)
    {
        $orderId = $request->get('order_id');
        $productId = $request->get('product_id');

        // Validate that order belongs to current user and is completed
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->where('status', Order::STATUS_SELESAI)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan atau belum selesai.');
        }

        // Validate that product exists in this order
        $orderItem = OrderItem::where('order_id', $orderId)
            ->where('product_id', $productId)
            ->first();

        if (!$orderItem) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan dalam pesanan.');
        }

        // Check if testimonial already exists
        $existingTestimonial = Testimonial::where('order_id', $orderId)
            ->where('product_id', $productId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingTestimonial) {
            return redirect()->back()->with('error', 'Anda sudah memberikan testimoni untuk produk ini.');
        }

        return view('testimonials.create', compact('order', 'orderItem'));
    }

    /**
     * Store testimonial
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Validate order ownership and status
        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->where('status', Order::STATUS_SELESAI)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak valid.');
        }

        // Check if testimonial already exists
        $existingTestimonial = Testimonial::where('order_id', $request->order_id)
            ->where('product_id', $request->product_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingTestimonial) {
            return redirect()->back()->with('error', 'Anda sudah memberikan testimoni untuk produk ini.');
        }

        try {
            $imagePath = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('testimonials', 'public');
            }

            // Create testimonial
            Testimonial::create([
                'user_id' => Auth::id(),
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'review' => $request->review,
                'image_path' => $imagePath,
                'is_approved' => false // Admin needs to approve
            ]);

            return redirect()->back()->with('success', 'Testimoni berhasil dikirim dan akan ditampilkan setelah disetujui admin.');

        } catch (\Exception $e) {
            Log::error('Error creating testimonial: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan testimoni.');
        }
    }

    /**
     * Get testimonials for a product (for displaying on product detail page)
     */
    public function getProductTestimonials($productId)
    {
        $testimonials = Testimonial::with(['user'])
            ->where('product_id', $productId)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($testimonials);
    }
}
