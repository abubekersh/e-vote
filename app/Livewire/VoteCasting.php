<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\candidate;
use App\Models\vote;
use Illuminate\Support\Facades\Auth;

class VoteCasting extends Component
{
    public $candidates = [];
    public $selectedCandidate = null;
    public $confirming = false;
    public $voted = false;

    public function mount()
    {
        $this->candidates = Candidate::with('party')->get();
    }

    public function selectCandidate($candidateId)
    {
        dd($candidateId);
        $this->selectedCandidate = $candidateId;
        $this->confirming = true;
    }

    public function castVote()
    {
        if (!$this->selectedCandidate || $this->voted) return;

        Vote::create([
            'voter_id' => Auth::id(),
            'candidate_id' => $this->selectedCandidate,
        ]);

        $this->voted = true;
        $this->confirming = false;
    }

    public function render()
    {
        return view('livewire.vote-casting');
    }
}
