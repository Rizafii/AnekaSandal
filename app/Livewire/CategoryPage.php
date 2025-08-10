<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryPage extends Component
{
    public $categories = [];
    public $selectedCategory = null;
    public $search = '';

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $query = Category::active()->withCount('products');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        $this->categories = $query->orderBy('name')->get();
    }

    public function updatedSearch()
    {
        $this->loadCategories();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = Category::withCount('products')->find($categoryId);
    }

    public function clearSelection()
    {
        $this->selectedCategory = null;
    }

    public function render()
    {
        return view('livewire.category-page');
    }
}
