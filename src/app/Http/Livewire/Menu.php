<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Menu extends Component
{
    public $showMenu = false;

    public function render()
    {
        return view('livewire.menu');
    }
    public function openMenu()
    {
        $this->showMenu = true;
    }

    public function closeMenu()
    {
        $this->showMenu = false;
    }
}
