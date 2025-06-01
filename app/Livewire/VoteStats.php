<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class VoteStats extends Component
{
    public $candidates = [];
    public $voteCounts = [45];

    public function render()
    {
        return view('livewire.vote-stats');
    }

    public function mount()
    {
        $this->candidates = User::pluck('name')->toArray();
        $this->voteCounts = User::pluck('name')->toArray();
    }
}
