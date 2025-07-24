<?php

namespace App\Livewire;

use Livewire\Component;

class Navbar extends Component
{
    public $search = '';
    public $showMobileMenu = false;
    public $showUserDropdown = false;

    public function toggleMobileMenu()
    {
        $this->showMobileMenu = !$this->showMobileMenu;
    }

    public function toggleUserDropdown()
    {
        $this->showUserDropdown = !$this->showUserDropdown;
    }

    public function searchProducts()
    {
        // Implement search logic here
        if ($this->search) {
            // You can emit an event or redirect to search results
            $this->dispatch('search-products', search: $this->search);
        }
    }

    public function clearSearch()
    {
        $this->search = '';
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
