<?php

namespace App\Livewire\Modals;

use App\Models\Eligibility_Type;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class EligibilityModal extends Component
{

    public $eligibilityId, $eligibilityName, $eligibilityDate;
    public $editIndex = null;
    public $search;

    #[Modelable]
    public $eligibilityData = [];

    public function save()
    {

        $rules = [
            'eligibilityId' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Check if we are editing an existing certificate
                    if ($this->editIndex !== null) {
                        // Check if the certTypeID is already in the list, excluding the current edit index
                        $existingEligibility = collect($this->eligibilityData)
                            ->except($this->editIndex)
                            ->contains('eligibilityId', $value);
                    } else {
                        // Check if the certTypeID is already in the list
                        $existingEligibility = collect($this->eligibilityData)
                            ->contains('eligibilityId', $value);
                    }

                    if ($existingEligibility) {
                        $fail("The eligibility is already in the list.");
                    }
                },
            ],
            'eligibilityDate' => 'required|date',

        ];

        $messages = [
            'eligibilityId.required' => 'The eligibility field is required.',
            'eligibilityDate.required' => 'The eligibility date is required.',
            'eligibilityDate.date' => 'The eligibility date must be a valid date.',
        ];

        $this->validate($rules, $messages);

        $eligibilityData = [
            'eligibilityId' => $this->eligibilityId,
            'eligibilityDate' => $this->eligibilityDate,
            'eligibilityName' => $this->eligibilityName,
        ];

        if ($this->editIndex !== null) {
            $this->eligibilityData[$this->editIndex] = $eligibilityData;
            toastr()->success('Record Updated!');
        } else {
            $this->eligibilityData[] = $eligibilityData;
            toastr()->success('Record added!');
        }

        $this->dispatch('refreshEligibilityLicense');
        $this->close();

    }

    #[On('editEligibility')]
    public function editEligibility($id)
    {
        $index = array_search($id, array_column($this->eligibilityData, 'eligibilityId'));

        if ($index !== false) {
            $this->eligibilityId = $this->eligibilityData[$index]['eligibilityId'];
            $this->eligibilityDate = $this->eligibilityData[$index]['eligibilityDate'];
            $this->eligibilityName = $this->eligibilityData[$index]['eligibilityName'];
            $this->editIndex = $index;
            $this->dispatch('open-modal', 'eligibility-modal');
        }
    }

    public function selectEligibility($id)
    {
        $eligibility = Eligibility_Type::findOrFail($id);

        if ($eligibility) {
            $this->eligibilityId = $id;
            $this->eligibilityName = $eligibility->eligibility_Name;
        }
    }

    public function close()
    {
        $this->resetValidation();
        $this->reset('eligibilityId', 'eligibilityDate', 'eligibilityName', 'editIndex', 'search');
        $this->dispatch('close-modal', 'eligibility-modal');
    }

    public function render()
    {

        $eligibility = Eligibility_Type::where('eligibility_Status', 1)->where('eligibility_Name', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.modals.eligibility-modal', compact('eligibility'));
    }
}
