<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class AdminSidebar extends Component
{
    public $showSidebar = false;
    public $showUserDropdown = false;

    public function toggleSidebar()
    {
        $this->showSidebar = !$this->showSidebar;
    }

    public function toggleUserDropdown()
    {
        $this->showUserDropdown = !$this->showUserDropdown;
    }

    public function closeSidebar()
    {
        $this->showSidebar = false;
    }

    public function closeUserDropdown()
    {
        $this->showUserDropdown = false;
    }

    public function render()
    {
        return view('livewire.admin.admin-sidebar');
    }
}
