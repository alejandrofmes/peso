<?php

namespace App\Livewire\Modals;

use App\Models\Barangay;
use App\Models\PESO;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class BarangaySignupModal extends Component
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

        $pesoMunicipalityIds = PESO::distinct('municipality_id')->pluck('municipality_id');

        $barangay = Barangay::with(['municipality.province'])
            ->where(function ($query) use ($pesoMunicipalityIds) {
                // Condition to filter barangays by municipalities with PESO accounts
                $query->whereHas('municipality', function ($query) use ($pesoMunicipalityIds) {
                    $query->whereIn('municipality_id', $pesoMunicipalityIds);
                })
                    ->where(function ($query) {
                        // Additional conditions for barangay name, municipality name, or province name
                        $query->where('barangay_Name', 'like', '%' . $this->search . '%')
                            ->orWhereHas('municipality', function ($query) {
                                $query->where('municipality_Name', 'like', '%' . $this->search . '%');
                            })
                            ->orWhereHas('municipality.province', function ($query) {
                                $query->where('province_Name', 'like', '%' . $this->search . '%');
                            });
                    });
            })
            ->orderBy('barangay_Name', 'ASC')
            ->paginate(10);

        return view('livewire.modals.barangay-signup-modal', compact('barangay'));
    }
}
