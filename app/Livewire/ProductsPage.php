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

    public $products;
    public $categories;

    public function mount()
    {
        $this->categories = Category::all();
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

        $this->products = $query->paginate(24);
    }

    public function updatedSortBy()
    {
        $this->loadProducts();
    }

    public function updatedPriceRange()
    {
        $this->loadProducts();
    }

    public function updatedCategoryFilter()
    {
        $this->loadProducts();
    }

    public function updatedSearch()
    {
        $this->loadProducts();
    }

    public function render()
    {
        return view('livewire.products-page');
    }
}
