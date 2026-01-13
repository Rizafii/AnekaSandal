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

        // Search filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            $isActive = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $isActive);
        }

        // Stock filter - Calculate based on variants
        if ($request->filled('stock')) {
            switch ($request->stock) {
                case 'in_stock':
                    $query->whereHas('variants', function ($q) {
                        $q->selectRaw('product_id, SUM(stock) as total_stock')
                            ->groupBy('product_id')
                            ->havingRaw('SUM(stock) > 5');
                    });
                    break;
                case 'low_stock':
                    $query->whereHas('variants', function ($q) {
                        $q->selectRaw('product_id, SUM(stock) as total_stock')
                            ->groupBy('product_id')
                            ->havingRaw('SUM(stock) BETWEEN 1 AND 5');
                    });
                    break;
                case 'out_of_stock':
                    $query->where(function ($q) {
                        $q->whereDoesntHave('variants')
                            ->orWhereHas('variants', function ($subQ) {
                                $subQ->selectRaw('product_id, SUM(stock) as total_stock')
                                    ->groupBy('product_id')
                                    ->havingRaw('SUM(stock) <= 0');
                            });
                    });
                    break;
            }
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20);

        // Transform products to include calculated stock from variants
        $products->getCollection()->transform(function ($product) {
            // Calculate total stock from active variants
            $totalStock = $product->variants->where('is_active', true)->sum('stock');
            $product->calculated_stock = $totalStock;
            return $product;
        });

        $categories = Category::active()->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'description' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
            'variants' => 'nullable|array',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.additional_price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();

        // Generate SKU if not provided
        if (empty($data['sku'])) {
            $data['sku'] = 'PRD-' . strtoupper(uniqid());
        }

        // Generate slug from name
        $data['slug'] = Str::slug($request->name);

        $product = Products::create($data);

        // Handle multiple images - save with full URL like categories
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => asset('storage/' . $imagePath)
                ]);
            }
        }

        // Handle variants
        if ($request->filled('variants')) {
            foreach ($request->variants as $variantData) {
                if (!empty($variantData['size']) || !empty($variantData['color'])) {
                    $product->variants()->create([
                        'size' => $variantData['size'] ?? null,
                        'color' => $variantData['color'] ?? null,
                        'additional_price' => $variantData['additional_price'] ?? 0,
                        'stock' => $variantData['stock'] ?? 0,
                        'is_active' => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.additional_price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Generate slug from name
        $data['slug'] = Str::slug($request->name);

        $product->update($data);

        // Handle image deletion
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    // Delete physical file
                    $imagePath = str_replace(asset('storage/'), '', $image->image_path);
                    Storage::disk('public')->delete($imagePath);
                    // Delete from database
                    $image->delete();
                }
            }
        }

        // Handle new images - save with full URL like categories
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => asset('storage/' . $imagePath)
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
                        $variant = $product->variants()->find($variantData['id']);
                        if ($variant) {
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
                        $variant = $product->variants()->create([
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

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Products $product)
    {
        try {
            // Delete product images
            if ($product->images->isNotEmpty()) {
                foreach ($product->images as $image) {
                    $imagePath = str_replace(asset('storage/'), '', $image->image_path);
                    Storage::disk('public')->delete($imagePath);
                    $image->delete();
                }
            }

            // Delete product
            $product->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus.');

        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk ini ada dalam order user'
                ], 500);
            }

            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan saat menghapus produk.');
        }
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