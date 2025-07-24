<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Products;

class SearchResults extends Component
{
    public $search = '';
    public $results = [];
    public $showResults = false;

    protected $listeners = ['search-products' => 'performSearch'];

    public function mount($search = '')
    {
        $this->search = $search;
        if ($this->search) {
            $this->performSearch($this->search);
        }
    }

    public function performSearch($searchTerm = null)
    {
        if ($searchTerm) {
            $this->search = $searchTerm;
        }

        if (strlen($this->search) >= 2) {
            $this->showResults = true;
            // Search in products with active scope and eager loading
            $this->results = Products::active()
                ->with(['category', 'images'])
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                })
                ->limit(5)
                ->get();
        } else {
            $this->results = [];
            $this->showResults = false;
        }
    }

    public function selectProduct($productId)
    {
        // Redirect to product detail page
        return redirect()->route('product.show', $productId);
    }

    public function render()
    {
        return view('livewire.search-results');
    }
}
