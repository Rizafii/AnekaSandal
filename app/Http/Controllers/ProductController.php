<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = null;
        if ($request->category) {
            $categoryId = Category::where('slug', $request->category)->value('id');
        }
        $products = Products::active()
            ->with(['category', 'images', 'variants'])
            ->paginate(12);

        // Transform data untuk view compatibility
        $products->getCollection()->transform(function ($product) {
            return (object) [
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

        return view('products', compact('products', 'categoryId'));
    }

    public function show($id)
    {
        $product = Products::active()
            ->with(['category', 'images', 'variants'])
            ->findOrFail($id);

        // Convert product data untuk view compatibility
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'original_price' => null,
            'discount' => 0,
            'category' => $product->category->name ?? 'Tidak Berkategori',
            'images' => $product->images->map(function ($image) {
                return [
                    'image_url' => $image->url ?? 'https://via.placeholder.com/300x300/f3f4f6/6b7280?text=No+Image'
                ];
            })->toArray(),
            'rating' => 4.5,
            'reviews_count' => 127,
            'sold_count' => 1250,
            'stock' => $product->variants->where('is_active', true)->sum('stock'),
            'sizes' => $product->variants->pluck('size')->unique()->values()->toArray(),
            'colors' => $product->variants->pluck('color')->unique()->values()->toArray(),
        ];

        return view('product-detail', ['product' => $productData]);
    }
}
