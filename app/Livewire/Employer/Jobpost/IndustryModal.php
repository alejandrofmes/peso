<?php

namespace App\Livewire\Employer\Jobpost;

use App\Models\Job_Industry;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class IndustryModal extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search;

    
    public function updatedSearch()
    {
        $this->resetPage();
    }

    
    public function industrySelect($id)
    {
        $this->dispatch('industrySelect', $id);
        $this->dispatch('close');
        $this->resetPage();
    }

    public function render()
    {

        $industry = Job_Industry::where('industry_Status', 1)->where('industry_Title', 'like', '%' . $this->search . '%')
            ->paginate(8);

        return view('livewire.employer.jobpost.industry-modal', compact('industry'));
    }
}
