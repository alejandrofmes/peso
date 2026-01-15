<?php

namespace App\Livewire\Employer\Jobpost;

use App\Models\Job_Positions;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class JobPositionsModal extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function tagSelect($id)
    {
        $this->dispatch('tagSelect', $id);

    }
    #[On('close-modal')]
    public function closeModal()
    {
        // $this->dispatch('close');

    }

    public function render()
    {
        $jobposition = Job_Positions::where('position_Status', 1)->where('position_Title', 'like', '%' . $this->search . '%')
            ->paginate(8);

        return view('livewire.employer.jobpost.job-positions-modal', compact('jobposition'));
    }
}
