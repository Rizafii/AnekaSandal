<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 6 produk terbaru untuk homepage
        $latestProducts = Products::active()
            ->with(['category', 'images', 'variants'])
            ->latest()
            ->take(6)
            ->get();

        // Transform data untuk view compatibility
        $productsData = $latestProducts->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'original_price' => null, // Akan ditambahkan nanti jika diperlukan
                'discount' => 0, // Default 0% discount
                'category' => $product->category->name ?? 'Tidak Berkategori',
                'image' => $product->images->first()?->url ?? 'https://via.placeholder.com/300x300/f3f4f6/6b7280?text=No+Image',
                'rating' => 4.5,
                'reviews_count' => rand(50, 200),
                'stock' => $product->variants->where('is_active', true)->sum('stock'),
            ];
        });

        return view('home', ['latestProducts' => $productsData]);
    }

    public function promos()
    {
        return view('home'); // You can create specific pages later
    }

    public function contact()
    {
        return view('home'); // You can create specific pages later
    }
}
