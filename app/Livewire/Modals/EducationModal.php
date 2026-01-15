<?php

namespace App\Livewire\Modals;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class EducationModal extends Component
{

    public $eduSchool, $eduLevel = "", $eduCourse, $eduStart, $eduEnd, $eduOngoing;

    #[Modelable]
    public $educationData = [];
    public $editIndex = null;

    public function addEducation()
    {

        $rules = [
            'eduSchool' => 'required|string|max:255',
            'eduLevel' => 'required|numeric',
            'eduCourse' => [
                function ($attribute, $value, $fail) {
                    if ($this->eduLevel >= 19 && empty($value)) {
                        $fail('You must input a course');
                    }
                },
                'max:255',
            ],
            'eduStart' => [
                'required',
                'date',
                'before_or_equal:today', // Ensure eduStart is not in the future
            ],
            'eduEnd' => [
                'nullable',
                'date',
                'before_or_equal:today', // Ensure eduEnd is not in the future
                'after:eduStart', // Ensure eduEnd is after or equal to eduStart
            ],
        ];

        if (!$this->eduOngoing) {
            $rules['eduEnd'][] = 'required'; // Ensure eduEnd is required if eduOngoing is false
        }

        $messages = [
            'eduSchool.required' => 'The school name is required.',
            'eduSchool.string' => 'The school name must be a string.',
            'eduSchool.max' => 'The school name must not exceed 255 characters.',
            'eduLevel.required' => 'The education level is required.',
            'eduLevel.numeric' => 'The education level must be a number.',
            'eduCourse.required' => 'The course name is required.',
            'eduCourse.string' => 'The course name must be a string.',
            'eduCourse.max' => 'The course name must not exceed 255 characters.',
            'eduStart.required' => 'The start date is required.',
            'eduStart.date' => 'The start date must be a valid date.',
            'eduStart.before_or_equal' => 'The start date must be a date before or equal to today.',
            'eduEnd.date' => 'The end date must be a valid date.',
            'eduEnd.before_or_equal' => 'The end date must be a date before or equal to today.',
            'eduEnd.after' => 'The end date must be a date after the start date.',
            'eduEnd.required' => 'The end date is required when education is not ongoing.',
        ];

        $this->validate($rules, $messages);

        $educationData = [
            'eduSchool' => $this->eduSchool,
            'eduLevel' => $this->eduLevel,
            'eduCourse' => $this->eduCourse,
            'eduStart' => $this->eduStart,
            // 'eduEnd' => $this->eduEnd,
            'eduEnd' => $this->eduEnd === null ? null : $this->eduEnd,

            'eduOngoing' => $this->eduOngoing,
        ];

        if ($this->editIndex !== null) {
            $this->educationData[$this->editIndex] = $educationData;
            toastr()->success('Record Updated!');
        } else {
            $this->educationData[] = $educationData;
            toastr()->success('Record added!');
        }

        $this->dispatch('refreshEdu');
        $this->close();
    }

    #[On('editEducation')]
    public function editEducation($index)
    {
        $this->editIndex = $index;
        $this->eduSchool = $this->educationData[$index]['eduSchool'];
        $this->eduLevel = $this->educationData[$index]['eduLevel'];
        $this->eduCourse = $this->educationData[$index]['eduCourse'];
        $this->eduStart = $this->educationData[$index]['eduStart'];
        $this->eduEnd = $this->educationData[$index]['eduEnd'];
        $this->eduOngoing = $this->educationData[$index]['eduOngoing'];
        $this->dispatch('open-modal', 'education-modal');
    }

    public function close()
    {
        $this->resetValidation();
        $this->dispatch('close-modal', 'education-modal');
        $this->reset('eduSchool', 'eduLevel', 'eduCourse', 'eduStart', 'eduEnd', 'editIndex');
        $this->eduOngoing = false;
    }

    public function render()
    {
        return view('livewire.modals.education-modal');
    }
}
