<?php

namespace App\Livewire\Modals;

use App\Models\Barangay;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class BarangayModal extends Component
{
    use WithPagination, WithoutUrlPagination; 

    public $search;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function barSelect($id)
    {

        $this->dispatch('barSelect', id: $id);
        $this->dispatch('close-modal', 'barangay-modal');
        $this->resetPage();
    }

    public function render()
    {


        $barangay = Barangay::with('municipality.province')
            ->where('barangay_Name', 'like', '%' . $this->search . '%')
            ->orWhereHas('municipality', function ($query) {
                $query->where('municipality_Name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('municipality.province', function ($query) {
                $query->where('province_Name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('barangay_Name', 'ASC')
            ->paginate(10);

        return view('livewire.modals.barangay-modal', compact('barangay'));
    }
}
