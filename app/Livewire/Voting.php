<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Election;
use App\Models\Position;

class Voting extends Component
{
    public Election $election;

    public $positions;

    public function mount(Election $election)
    {
        //TODO check if user voted already
        $currentDateTime = now()->format('Y-m-d H:i:s');

        $present = $election->where('start', '<=', $currentDateTime)->where('end', '>=', $currentDateTime)->first();
        
        if (!$present)
        {
            abort(403);
        }

        $course = $election->courses->where('id', auth()->user()->course_id)->first();
        
        if ($course === null)
        {
            abort(403);
        }

        $positions_id = [];

        foreach ($election->candidates as $candidate) {
            array_push($positions_id, $candidate['position_id']);
        }

        $this->positions = Position::whereIn('id', $positions_id)->get();

    }



    public function render()
    {
        return view('livewire.voting', [
            'positions' => $this->positions
        ]);
    }
}
