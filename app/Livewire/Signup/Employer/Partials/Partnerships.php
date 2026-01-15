<?php

namespace App\Livewire\Signup\Employer\Partials;

use App\Models\PESO;
use Livewire\Attributes\On;
use Livewire\Component;

class Partnerships extends Component
{

    public $partnershipData = [];

    public $stepNumber = 3;

    public function removePartnership($id)
    {
        $index = array_search($id, array_column($this->partnershipData, 'peso_id'));

        if ($index !== false) {
            unset($this->partnershipData[$index]);
            $this->partnershipData = array_values($this->partnershipData);
            toastr()->error('Record removed!');

        }
    }

    #[On('selectPartnership')]
    public function addPartnership($id)
    {

        if (collect($this->partnershipData)->contains('peso_id', $id)) {
            toastr()->warning('This peso municipality is already selected.');
            return;
        }

        // If the job position does not exist in the array, add it
        $peso = PESO::findOrFail($id);

        if ($peso) {
            $this->partnershipData[] = [
                'peso_id' => $peso->peso_id,
                'municipality_Name' => $peso->municipality->municipality_Name,
            ];
            $this->dispatch('close-modal', 'partnership-modal');
        } else {
            toastr()->error('Could not fetch data');
            $this->dispatch('close-modal', 'partnership-modal');
        }

    }

    public function next()
    {

        $this->validate([
            'partnershipData' => 'required|array|min:1', // Ensure the array is not empty
            'partnershipData.*' => 'required', // Ensure each item in the array is required
        ], [
            'partnershipData.required' => 'At least one partnership record is required.',
            'partnershipData.min' => 'At least one partnership record is required.',
            'partnershipData.*.required' => 'Each partnership entry is required.',
        ]);

        $this->dispatch('handleStepData', $this->stepNumber, [
            'partnershipData' => $this->partnershipData,

        ]);

        // dd($this->partnershipData);
        $this->dispatch('nextStep', $this->stepNumber + 1);

    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);

    }

    public function render()
    {
        return view('livewire.signup.employer.partials.partnerships');
    }
}
