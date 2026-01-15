<?php

namespace App\Livewire\Signup\Jobseeker\Partials;

use Livewire\Attributes\On;
use Livewire\Component;

class WorkExperience extends Component
{

    public $workExperienceData = [];

    public $stepNumber = 9;
    public function editWorkExperience($index)
    {
        $this->dispatch('editWorkExperience', index: $index);
    }

    public function removeWorkExperience($index)
    {
        unset($this->workExperienceData[$index]);
        $this->workExperienceData = array_values($this->workExperienceData);
        toastr()->error('Record removed!');
    }

    public function next()
    {
        $this->dispatch('handleStepData', $this->stepNumber, [
            'workExperienceData' => $this->workExperienceData,
        ]);

        $this->dispatch('nextStep', $this->stepNumber + 1);
    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);
    }

    #[On('refreshWorkExp')]
    public function render()
    {
        return view('livewire.signup.jobseeker.partials.work-experience');
    }
}
