<?php

namespace App\Livewire\Signup\Jobseeker\Partials;

use Livewire\Attributes\On;
use Livewire\Component;

class CertificationTraining extends Component
{

    public $certificateData = [], $trainingData = [];

    public $stepNumber = 7;

    public function editCertificate($id)
    {
        $this->dispatch('editCertificate', id: $id);
    }

    public function removeCertificate($id)
    {
        $index = array_search($id, array_column($this->certificateData, 'certTypeID'));

        if ($index !== false) {
            unset($this->certificateData[$index]);
            $this->certificateData = array_values($this->certificateData);
            toastr()->error('Record removed!');

        }
    }

    public function editTraining($index)
    {
        $this->dispatch('editTraining', index: $index);
    }

    public function removeTraining($index)
    {

        unset($this->trainingData[$index]);
        $this->trainingData = array_values($this->trainingData);
        toastr()->success('Record removed!');

    }

    public function next()
    {
        $this->dispatch('handleStepData', $this->stepNumber, [
            'certificateData' => $this->certificateData,
            'trainingData' => $this->trainingData,
        ]);
        $this->dispatch('nextStep', $this->stepNumber + 1);
    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);
    }

    #[On('refreshCertTrain')]
    public function render()
    {
        return view('livewire.signup.jobseeker.partials.certification-training');
    }
}
