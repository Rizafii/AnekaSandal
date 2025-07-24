<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategorySection extends Component
{
    public $categories = [];
    public $currentIndex = 0;
    public $itemsPerView = 4;

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::active()->get()->toArray();
    }

    public function scrollLeft()
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }
    }

    public function scrollRight()
    {
        $maxIndex = max(0, count($this->categories) - $this->itemsPerView);
        if ($this->currentIndex < $maxIndex) {
            $this->currentIndex++;
        }
    }

    public function getVisibleCategories()
    {
        return array_slice($this->categories, $this->currentIndex, $this->itemsPerView);
    }

    public function canScrollLeft()
    {
        return $this->currentIndex > 0;
    }

    public function canScrollRight()
    {
        return $this->currentIndex < (count($this->categories) - $this->itemsPerView);
    }

    public function render()
    {
        return view('livewire.category-section', [
            'visibleCategories' => $this->getVisibleCategories(),
            'canScrollLeft' => $this->canScrollLeft(),
            'canScrollRight' => $this->canScrollRight()
        ]);
    }
}
