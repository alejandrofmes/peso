<?php

namespace App\Livewire\Signup\Jobseeker\Partials;

use Livewire\Attributes\On;
use Livewire\Component;

class Education extends Component
{
    // #[Reactive]
    public $educationData = [];

    public $stepNumber = 6;

    public $eduLevels = [
        '1' => 'GRADE I',
        '2' => 'GRADE II',
        '3' => 'GRADE III',
        '4' => 'GRADE IV',
        '5' => 'GRADE V',
        '6' => 'GRADE VI',
        '7' => 'GRADE VII',
        '8' => 'GRADE VIII',
        '9' => 'ELEMENTARY GRADUATE',
        '10' => '1ST YEAR HIGH SCHOOL/GRADE VII (FOR K TO 12)',
        '11' => '2ND YEAR HIGH SCHOOL/GRADE VIII (FOR K TO 12)',
        '12' => '3RD YEAR HIGH SCHOOL/GRADE IX (FOR K TO 12)',
        '13' => '4TH YEAR HIGH SCHOOL/GRADE X (FOR K TO 12)',
        '14' => 'GRADE XI (FOR K TO 12)',
        '15' => 'GRADE XII (FOR K TO 12)',
        '16' => 'HIGH SCHOOL GRADUATE',
        '17' => 'VOCATIONAL UNDERGRADUATE',
        '18' => 'VOCATIONAL GRADUATE',
        '19' => '1ST YEAR COLLEGE LEVEL',
        '20' => '2ND YEAR COLLEGE LEVEL',
        '21' => '3RD YEAR COLLEGE LEVEL',
        '22' => '4TH YEAR COLLEGE LEVEL',
        '23' => '5TH YEAR COLLEGE LEVEL',
        '24' => 'COLLEGE GRADUATE',
        '25' => 'MASTERAL/POST GRADUATE LEVEL',
        '26' => 'MASTERAL/POST GRADUATE',
    ];

    public function editEducation($index)
    {
        $this->dispatch('editEducation', index: $index);
    }

    public function removeEducation($index)
    {
        unset($this->educationData[$index]);
        $this->educationData = array_values($this->educationData);
        toastr()->error('Record removed!');
    }

    public function next()
    {
        $this->validate([
            'educationData' => 'required|array|min:1',
        ]);

        $this->dispatch('handleStepData', $this->stepNumber, [
            'educationData' => $this->educationData,
        ]);
        $this->dispatch('nextStep', $this->stepNumber + 1);
    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);
    }

    #[On('refreshEdu')]
    public function render()
    {
        return view('livewire.signup.jobseeker.partials.education');

    }
}
