<?php

namespace App\Livewire;

use Livewire\Component;

class ToggleButton extends Component
{
    public $isOpen = false;
    protected $listeners = ['toggleMenu'];

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
        $this->dispatch('menuToggled', $this->clicked);
    }
    public function render()
    {
        return view('livewire.toggle-button');
    }
}
