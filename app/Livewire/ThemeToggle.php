<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeToggle extends Component
{
    public $showMenu = false;
    public $currentTheme = 'system';

    public function mount()
    {
        // Get theme from session/cookie if needed
        $this->currentTheme = session('theme', 'system');
    }

    public function toggleMenu()
    {
        $this->showMenu = !$this->showMenu;
    }

    public function setTheme($theme)
    {
        $this->currentTheme = $theme;
        session(['theme' => $theme]);
        $this->showMenu = false;

        // Dispatch event to update theme
        $this->dispatch('theme-changed', theme: $theme);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}
