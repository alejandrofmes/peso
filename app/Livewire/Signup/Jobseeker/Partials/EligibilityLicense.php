<?php

namespace App\Livewire\Signup\Jobseeker\Partials;

use Livewire\Attributes\On;
use Livewire\Component;

class EligibilityLicense extends Component
{

    public $eligibilityData = [], $licenseData = [];

    public $stepNumber = 8;

    public function editEligibility($id)
    {
        $this->dispatch('editEligibility', id: $id);
    }

    public function removeEligibility($id)
    {
        $index = array_search($id, array_column($this->eligibilityData, 'eligibilityId'));

        if ($index !== false) {
            unset($this->eligibilityData[$index]);
            $this->eligibilityData = array_values($this->eligibilityData);
            toastr()->error('Record removed!');

        }
    }

    public function editLicense($id)
    {
        $this->dispatch('editLicense', id: $id);
    }

    public function removeLicense($id)
    {
        $index = array_search($id, array_column($this->licenseData, 'licenseId'));

        if ($index !== false) {
            unset($this->licenseData[$index]);
            $this->licenseData = array_values($this->licenseData);
            toastr()->error('Record removed!');

        }
    }

    public function next()
    {
        $this->dispatch('handleStepData', $this->stepNumber, [
            'eligibilityData' => $this->eligibilityData,
            'licenseData' => $this->licenseData,
        ]);
        $this->dispatch('nextStep', $this->stepNumber + 1);
    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);
    }

    #[On('refreshEligibilityLicense')]
    public function render()
    {
        return view('livewire.signup.jobseeker.partials.eligibility-license');
    }
}
