<?php

namespace App\Livewire\Modals;

use App\Models\PESO;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class PartnershipModal extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $partnershipId, $partnershipName;
    public $search;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[Modelable]
    public $partnershipData = [];

    public function pesoSelect($id)
    {

        $this->dispatch('selectPartnership', $id);

    }

    public function render()
    {

        $PESO = PESO::whereHas('municipality', function ($query) {
            if ($this->search) {
                $query->where('municipality_Name', 'like', '%' . $this->search . '%');
            }
        })->paginate(10);

        return view('livewire.modals.partnership-modal', compact('PESO'));
    }
}
