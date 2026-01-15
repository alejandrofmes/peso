<?php

namespace App\Livewire\Signup\Jobseeker\Partials;

use Livewire\Component;

class OtherSkills extends Component
{

    public $inputSkills;
    
    public $checkBoxData = [], $inputData = [];
    public $skills = [
        'AUTO MECHANIC',
        'GARDENING',
        'BEAUTICIAN',
        'MASONRY',
        'CARPENTRY WORK',
        'PAINTER/ARTIST',
        'COMPUTER LITERATE',
        'PAINTING JOBS',
        'DOMESTIC CHORES',
        'PHOTOGRAPHY',
        'DRIVING',
        'SEWING DRESSES',
        'ELECTRICIAN',
        'STENOGRAPHY',
        'EMBROIDERY',
        'TAILORING',
    ];
    public $stepNumber = 10;

    public function addSkills()
    {
        $rules = [
            'inputSkills' => [
                'required',
                'min:3',
                function ($attribute, $value, $fail) {
                    $lowercaseValue = strtolower($value);
                    $checkBoxDataLowerCase = array_map('strtolower', $this->checkBoxData);
                    $inputDataLowerCase = array_map('strtolower', $this->inputData);

                    if (in_array($lowercaseValue, $checkBoxDataLowerCase) || in_array($lowercaseValue, $inputDataLowerCase)) {
                        $fail('The skill already exists.');
                    }
                },
            ],
        ];

        $messages = [
            'inputSkills.required' => 'The skill field is required.',
            'inputSkills.min' => 'You must atleast input 3 characters.',
            'inputSkills.unique' => 'The skill already exists.',
        ];

        $this->validate($rules, $messages);

        if (in_array(strtoupper($this->inputSkills), $this->skills)) {
            // If it matches, add to checkBoxData if not already added
            if (!in_array($this->inputSkills, $this->checkBoxData)) {
                $this->checkBoxData[] = strtoupper($this->inputSkills);
            }
        } else {
            // If it doesn't match, add to inputData if not already added
            if (!in_array(strtoupper($this->inputSkills), $this->inputData)) {
                $this->inputData[] = strtoupper($this->inputSkills);
            }
        }

        $this->reset('inputSkills');

    }
    public function removeSkills($data)
    {

        if (($index = array_search($data, $this->inputData)) !== false) {
            unset($this->inputData[$index]);
            $this->inputData = array_values($this->inputData);
        }
    }

    public function next()
    {
        $otherSkills = array_merge($this->checkBoxData, $this->inputData);

        $this->dispatch('handleStepData', $this->stepNumber, [
            'otherSkills' => $otherSkills,
        ]);

        $this->dispatch('nextStep', $this->stepNumber + 1);
    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);
    }

    public function render()
    {
        return view('livewire.signup.jobseeker.partials.other-skills');
    }
}
