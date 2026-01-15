<?php

namespace App\Livewire\Modals;

use App\Models\Certificate_Type;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class CertificateModal extends Component
{

    public $certName, $certTypeID, $certFrom, $certEarned, $certRate, $editIndex;

    #[Modelable]
    public $certificateData;
    public $search;

    public function save()
    {
        $rules = [
            'certTypeID' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Check if we are editing an existing certificate
                    if ($this->editIndex !== null) {
                        // Check if the certTypeID is already in the list, excluding the current edit index
                        $existingCert = collect($this->certificateData)
                            ->except($this->editIndex)
                            ->contains('certTypeID', $value);
                    } else {
                        // Check if the certTypeID is already in the list
                        $existingCert = collect($this->certificateData)
                            ->contains('certTypeID', $value);
                    }

                    if ($existingCert) {
                        $fail("The certificate is already in the list.");
                    }
                },
            ],
            'certFrom' => 'required|string|max:255',
            'certEarned' => [
                'required',
                'date',
                'before_or_equal:today', // Ensure certEarned is not in the future
            ],
            'certRate' => 'required|string',
        ];

        // Custom validation messages
        $messages = [
            'certTypeID.required' => 'The certificate type is required.',
            'certFrom.required' => 'The issuing organization is required.',
            'certFrom.string' => 'The issuing organization must be a string.',
            'certFrom.max' => 'The issuing organization must not exceed 255 characters.',
            'certEarned.required' => 'The date earned is required.',
            'certEarned.date' => 'The date earned must be a valid date.',
            'certEarned.before_or_equal' => 'The date earned must be a date before or equal to today.',
            'certRate.required' => 'The rating is required.',
            'certRate.string' => 'The rating must be a string.',
        ];

        // Perform validation
        $this->validate($rules, $messages);

        $certificateData = [
            'certTypeID' => $this->certTypeID,
            'certFrom' => $this->certFrom,
            'certEarned' => $this->certEarned,
            'certRate' => $this->certRate,
            'certName' => $this->certName,
        ];

        if ($this->editIndex !== null) {
            $this->certificateData[$this->editIndex] = $certificateData;
            toastr()->success('Record Updated!');
        } else {
            $this->certificateData[] = $certificateData;
            toastr()->success('Record added!');
        }

        $this->dispatch('refreshCertTrain');
        $this->close();

    }

    #[On('editCertificate')]
    public function editCertificate($id)
    {
        $index = array_search($id, array_column($this->certificateData, 'certTypeID'));

        if ($index !== false) {
            $this->certTypeID = $this->certificateData[$index]['certTypeID'];
            $this->certName = $this->certificateData[$index]['certName'];
            $this->certFrom = $this->certificateData[$index]['certFrom'];
            $this->certEarned = $this->certificateData[$index]['certEarned'];
            $this->certRate = $this->certificateData[$index]['certRate'];
            $this->editIndex = $index;
            $this->dispatch('open-modal', 'certificate-modal');

        }

    }

    public function selectCertificate($id)
    {
        $certificate = Certificate_Type::findOrFail($id);
        if ($certificate) {
            $this->certTypeID = $certificate->cert_type_id;
            $this->certName = $certificate->cert_Name;
        }
    }

    public function close()
    {
        $this->resetValidation();
        $this->reset('certName', 'certTypeID', 'certFrom', 'certEarned', 'certRate', 'editIndex', 'search');
        $this->dispatch('close-modal', 'certificate-modal');
    }

    public function render()
    {

        $certTypes = Certificate_Type::where('cert_Status', 1)->where('cert_Name', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.modals.certificate-modal', compact('certTypes'));
    }
}
