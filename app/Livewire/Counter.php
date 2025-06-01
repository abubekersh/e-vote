<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $image = '/images/burger-menu-left-svgrepo-com.svg';

    public function increment()
    {
        $this->image = "/images/close.svg";
    }
    public function decrement()
    {
        $this->image = "/images/burger-menu-left-svgrepo-com.svg";
    }
    public function render()
    {
        return view('livewire.counter');
    }
}
