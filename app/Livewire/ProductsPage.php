<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Products;
use App\Models\Category;

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
        $this->categories = Category::all()->toArray();
        $this->loadProducts();
    }

    public function setViewType($type)
    {
        $this->viewType = $type;
    }

    public function loadProducts()
    {
        $query = Products::with(['images', 'variants']);

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

    public function render()
    {
        return view('livewire.products-page');
    }
}
