<?php

namespace App\Livewire\Modals;

use App\Models\License_Type;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class LicenseModal extends Component
{

    public $licenseId, $licenseName, $licenseDate;
    public $editIndex = null;
    public $search;

    #[Modelable]
    public $licenseData = [];

    public function save()
    {

        $rules = [
            'licenseId' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Check if we are editing an existing certificate
                    if ($this->editIndex !== null) {
                        // Check if the certTypeID is already in the list, excluding the current edit index
                        $existingLicense = collect($this->licenseData)
                            ->except($this->editIndex)
                            ->contains('licenseId', $value);
                    } else {
                        // Check if the certTypeID is already in the list
                        $existingLicense = collect($this->licenseData)
                            ->contains('licenseId', $value);
                    }

                    if ($existingLicense) {
                        $fail("The license is already in the list.");
                    }
                },
            ],
            'licenseDate' => 'required|date',

        ];

        $messages = [
            'licenseId.required' => 'The license field is required.',
            'licenseDate.required' => 'The license date is required.',
            'licenseDate.date' => 'The license date must be a valid date.',
        ];

        $this->validate($rules, $messages);

        $licenseData = [
            'licenseId' => $this->licenseId,
            'licenseDate' => $this->licenseDate,
            'licenseName' => $this->licenseName,
        ];

        if ($this->editIndex !== null) {
            $this->licenseData[$this->editIndex] = $licenseData;
            toastr()->success('Record Updated!');
        } else {
            $this->licenseData[] = $licenseData;
            toastr()->success('Record added!');
        }

        $this->dispatch('refreshEligibilityLicense');
        $this->close();

    }

    #[On('editLicense')]
    public function editLicense($id)
    {
        $index = array_search($id, array_column($this->licenseData, 'licenseId'));

        if ($index !== false) {
            $this->licenseId = $this->licenseData[$index]['licenseId'];
            $this->licenseDate = $this->licenseData[$index]['licenseDate'];
            $this->licenseName = $this->licenseData[$index]['licenseName'];
            $this->editIndex = $index;
            $this->dispatch('open-modal', 'license-modal');
        }
    }

    public function selectLicense($id)
    {
        $license = License_Type::findOrFail($id);

        if ($license) {
            $this->licenseId = $id;
            $this->licenseName = $license->license_Name;
        }
    }

    public function close()
    {
        $this->resetValidation();
        $this->reset('licenseId', 'licenseDate', 'licenseName', 'editIndex', 'search');
        $this->dispatch('close-modal', 'license-modal');
    }

    public function render()
    {

        $license = License_Type::where('license_Status', 1)->where('license_Name', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.modals.license-modal', compact('license'));
    }
}
