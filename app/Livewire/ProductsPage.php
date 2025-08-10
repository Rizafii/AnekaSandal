<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Products;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductsPage extends Component
{
    public $viewType = 'grid'; // grid or list
    public $sortBy = 'newest';
    public $priceRange = '';
    public $categoryFilter = '';
    public $search = '';

    public $products = [];
    public $categories = [];
    public $currentPage = 1;
    public $lastPage = 1;
    public $total = 0;
    public $perPage = 24;

    public function mount()
    {
        // Only get active categories
        $this->categories = Category::where('is_active', true)->get()->toArray();
        $this->loadProducts();
    }

    public function setViewType($type)
    {
        $this->viewType = $type;
    }

    public function loadProducts()
    {
        $query = Products::with(['images', 'variants']);

        // Only show active products
        $query->where('is_active', true);

        // Apply filters
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->priceRange) {
            $ranges = explode('-', $this->priceRange);
            if (count($ranges) == 2) {
                if ($ranges[1] === 'up') {
                    $query->where('price', '>=', $ranges[0]);
                } else {
                    $query->whereBetween('price', $ranges);
                }
            }
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
        }

        $paginatedProducts = $query->paginate($this->perPage, ['*'], 'page', $this->currentPage);

        // Convert to array format for Livewire
        $this->products = $paginatedProducts->getCollection()->map(function ($product) {
            return [
                'id' => $product->id,
                'category_id' => $product->category_id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'price' => $product->price,
                'weight' => $product->weight,
                'is_active' => $product->is_active,
                'featured' => $product->featured,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'images' => $product->images->toArray(),
                'variants' => $product->variants->toArray(),
                // Calculate total stock from variants
                'total_stock' => $product->variants->sum('stock'),
                // Get primary image
                'primary_image' => $product->images->where('is_primary', true)->first()?->image_path ??
                    $product->images->first()?->image_path,
            ];
        })->toArray();

        $this->currentPage = $paginatedProducts->currentPage();
        $this->lastPage = $paginatedProducts->lastPage();
        $this->total = $paginatedProducts->total();
    }

    public function updatedSortBy()
    {
        $this->currentPage = 1;
        $this->loadProducts();
    }

    public function updatedPriceRange()
    {
        $this->currentPage = 1;
        $this->loadProducts();
    }

    public function updatedCategoryFilter()
    {
        $this->currentPage = 1;
        $this->loadProducts();
    }

    public function updatedSearch()
    {
        $this->currentPage = 1; // Reset to first page when searching
        $this->loadProducts();
    }

    public function nextPage()
    {
        if ($this->currentPage < $this->lastPage) {
            $this->currentPage++;
            $this->loadProducts();
        }
    }

    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->loadProducts();
        }
    }

    public function gotoPage($page)
    {
        if ($page >= 1 && $page <= $this->lastPage) {
            $this->currentPage = $page;
            $this->loadProducts();
        }
    }

    public function getFirstItem()
    {
        return ($this->currentPage - 1) * $this->perPage + 1;
    }

    public function getLastItem()
    {
        return min($this->currentPage * $this->perPage, $this->total);
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->priceRange = '';
        $this->sortBy = 'newest';
        $this->currentPage = 1;
        $this->loadProducts();
    }

    public function addToCart($productId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.');
            return redirect()->route('login');
        }

        $product = Products::with('variants')->find($productId);

        if (!$product || !$product->is_active) {
            session()->flash('error', 'Produk tidak tersedia.');
            return;
        }

        // Check if product has stock
        $totalStock = $product->variants->sum('stock');
        if ($totalStock <= 0) {
            session()->flash('error', 'Stok produk habis.');
            return;
        }

        // Get the first available variant (you might want to modify this logic)
        $variant = $product->variants->where('stock', '>', 0)->first();

        if (!$variant) {
            session()->flash('error', 'Varian produk tidak tersedia.');
            return;
        }

        // Check if item already exists in cart
        $existingCartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->where('product_variant_id', $variant->id)
            ->first();

        if ($existingCartItem) {
            // Check if adding one more exceeds stock
            if ($existingCartItem->quantity + 1 > $variant->stock) {
                session()->flash('error', 'Jumlah melebihi stok yang tersedia.');
                return;
            }

            $existingCartItem->quantity += 1;
            $existingCartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'product_variant_id' => $variant->id,
                'quantity' => 1,
            ]);
        }

        session()->flash('success', 'Produk berhasil ditambahkan ke keranjang!');

        // Emit event to update cart count in navbar
        $this->dispatch('cartUpdated');
    }

    public function buyNow($productId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan login terlebih dahulu untuk melakukan pembelian.');
            return redirect()->route('login');
        }

        $product = Products::with('variants')->find($productId);

        if (!$product || !$product->is_active) {
            session()->flash('error', 'Produk tidak tersedia.');
            return;
        }

        // Check if product has stock
        $totalStock = $product->variants->sum('stock');
        if ($totalStock <= 0) {
            session()->flash('error', 'Stok produk habis.');
            return;
        }

        // Redirect to product detail page for variant selection
        return redirect()->route('product.detail', $product->id);
    }

    public function render()
    {
        return view('livewire.products-page');
    }
}
