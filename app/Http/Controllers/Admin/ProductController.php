<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
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
        $query = Products::with(['category', 'images', 'variants']);

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = Category::active()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'variants' => 'nullable|array',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.additional_price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'new_category_name' => 'nullable|string|max:255',
            'new_category_description' => 'nullable|string',
        ]);

        // Handle new category creation
        if ($request->filled('new_category_name')) {
            $category = Category::create([
                'name' => $request->new_category_name,
                'slug' => Str::slug($request->new_category_name),
                'description' => $request->new_category_description,
                'is_active' => true,
            ]);
            $validated['category_id'] = $category->id;
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['featured'] = $request->has('featured');

        $product = Products::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => Storage::url($path),
                    'alt_text' => $product->name . ' - Image ' . ($index + 1),
                    'is_primary' => $index === 0,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        // Handle variants
        if ($request->filled('variants')) {
            foreach ($request->variants as $variantData) {
                if (!empty($variantData['size']) || !empty($variantData['color'])) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $variantData['size'] ?? null,
                        'color' => $variantData['color'] ?? null,
                        'additional_price' => $variantData['additional_price'] ?? 0,
                        'stock' => $variantData['stock'] ?? 0,
                        'is_active' => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(Products $product)
    {
        $product->load(['category', 'images', 'variants']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Products $product)
    {
        $categories = Category::active()->get();
        $product->load(['category', 'images', 'variants']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Products $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.additional_price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.is_active' => 'boolean',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:product_images,id',
            'new_category_name' => 'nullable|string|max:255',
            'new_category_description' => 'nullable|string',
        ]);

        // Handle new category creation
        if ($request->filled('new_category_name')) {
            $category = Category::create([
                'name' => $request->new_category_name,
                'slug' => Str::slug($request->new_category_name),
                'description' => $request->new_category_description,
                'is_active' => true,
            ]);
            $validated['category_id'] = $category->id;
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['featured'] = $request->has('featured');

        $product->update($validated);

        // Handle image deletions
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image && $image->product_id === $product->id) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $image->image_path));
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $existingImagesCount = $product->images()->count();
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => Storage::url($path),
                    'alt_text' => $product->name . ' - Image ' . ($existingImagesCount + $index + 1),
                    'is_primary' => $product->images()->count() === 0 && $index === 0,
                    'sort_order' => $existingImagesCount + $index + 1,
                ]);
            }
        }

        // Handle variants update
        if ($request->filled('variants')) {
            $existingVariantIds = [];

            foreach ($request->variants as $variantData) {
                if (!empty($variantData['size']) || !empty($variantData['color'])) {
                    if (!empty($variantData['id'])) {
                        // Update existing variant
                        $variant = ProductVariant::find($variantData['id']);
                        if ($variant && $variant->product_id === $product->id) {
                            $variant->update([
                                'size' => $variantData['size'] ?? null,
                                'color' => $variantData['color'] ?? null,
                                'additional_price' => $variantData['additional_price'] ?? 0,
                                'stock' => $variantData['stock'] ?? 0,
                                'is_active' => isset($variantData['is_active']),
                            ]);
                            $existingVariantIds[] = $variant->id;
                        }
                    } else {
                        // Create new variant
                        $variant = ProductVariant::create([
                            'product_id' => $product->id,
                            'size' => $variantData['size'] ?? null,
                            'color' => $variantData['color'] ?? null,
                            'additional_price' => $variantData['additional_price'] ?? 0,
                            'stock' => $variantData['stock'] ?? 0,
                            'is_active' => true,
                        ]);
                        $existingVariantIds[] = $variant->id;
                    }
                }
            }

            // Delete variants that are not in the request
            $product->variants()->whereNotIn('id', $existingVariantIds)->delete();
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Products $product)
    {
        // Delete associated images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $image->image_path));
        }

        // Delete the product (cascade will handle variants and images)
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }

    public function toggleStatus(Products $product)
    {
        $product->update([
            'is_active' => !$product->is_active
        ]);

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Produk berhasil {$status}");
    }
}
