<?php

namespace App\Livewire\Modals;

use App\Models\Job_Positions;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class JobPositionModal extends Component
{

    use WithPagination, WithoutUrlPagination;
    public $search;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function positionSelect($id)
    {
        $this->dispatch('positionSelect', id: $id);

    }
    public function render()
    {

        $jobposition = Job_Positions::where('position_Status', 1)
            ->where('position_Title', 'like', '%' . $this->search . '%')
            ->paginate(8);

        return view('livewire.modals.job-position-modal', compact('jobposition'));
    }
}
