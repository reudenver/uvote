<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Election;
use Illuminate\Database\Eloquent\Collection;

class HomePage extends Component
{
    public $readyToLoad = false;

    public $currentDateTime;

    public function loadElections(): void
    {
        $this->readyToLoad = true;
    }

    public function mount(): void
    {
        $this->currentDateTime = now()->format('Y-m-d H:i:s');
    }

    public function getPresentElections(): Collection
    {
        return Election::where('start', '<=', $this->currentDateTime)
            ->where('end', '>=', $this->currentDateTime)
            ->get();
    }

    public function getUpcomingElections(): Collection
    {
        return Election::where('start', '>', $this->currentDateTime)->get();
    }

    public function getPastElections(): Collection
    {
        return Election::where('end', '<', $this->currentDateTime)->get();
    }

    public function render()
    {
        return view('livewire.home-page', [
            'present_elections' => $this->readyToLoad
                ? $this->getPresentElections()
                : [],
            'upcoming_elections' => $this->readyToLoad
                ? $this->getUpcomingElections()
                : [],
            'past_elections' => $this->readyToLoad
                ? $this->getPastElections()
                : [],
        ]);
    }
}
