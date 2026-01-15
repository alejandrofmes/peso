<?php

namespace App\Livewire\Modals;

use App\Models\Job_Positions;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class WorkExperienceModal extends Component
{
    public $workEmp, $workPositionId, $workPositionTitle, $workStatus = "", $workAdd, $workStart, $workEnd;
    public $editIndex = null;
    public $search;

    #[Modelable]
    public $workExperienceData = [];

    public function save()
    {

        $rules = [
            'workEmp' => 'required|string|max:255',
            'workPositionId' => 'required',
            'workStatus' => 'required',
            'workAdd' => 'required|string',
            'workStart' => [
                'required',
                'date',
                'before_or_equal:today', // Ensure workStart is not in the future
            ],
            'workEnd' => [
                'nullable',
                'date',
                'before_or_equal:today', // Ensure workEnd is not in the future
                'after:workStart', // Ensure workEnd is after or equal to workStart
            ],
        ];

        $messages = [
            'workEmp.required' => 'The employer name is required.',
            'workEmp.string' => 'The employer name must be a string.',
            'workEmp.max' => 'The employer name must not exceed 255 characters.',
            'workPositionId.required' => 'The position ID is required.',
            'workStatus.required' => 'The work status is required.',
            'workAdd.required' => 'The work address is required.',
            'workAdd.string' => 'The work address must be a string.',
            'workStart.required' => 'The start date is required.',
            'workStart.date' => 'The start date must be a valid date.',
            'workStart.before_or_equal' => 'The start date must be before or equal to today.',
            'workEnd.date' => 'The end date must be a valid date.',
            'workEnd.before_or_equal' => 'The end date must be before or equal to today.',
            'workEnd.after' => 'The end date must be after the start date.',
        ];

        $this->validate($rules, $messages);

        $workExperienceData = [
            'workEmp' => $this->workEmp,
            'workPositionId' => $this->workPositionId,
            'workPositionTitle' => $this->workPositionTitle,
            'workStatus' => $this->workStatus,
            'workAdd' => $this->workAdd,
            'workStart' => $this->workStart,
            'workEnd' => $this->workEnd === null ? null : $this->workEnd,

        ];

        if ($this->editIndex !== null) {
            $this->workExperienceData[$this->editIndex] = $workExperienceData;
            toastr()->success('Record Updated!');
        } else {
            $this->workExperienceData[] = $workExperienceData;
            toastr()->success('Record added!');
        }

        $this->dispatch('refreshWorkExp');
        $this->close();

    }

    #[On('editWorkExperience')]
    public function editWorkExperience($index)
    {
        $this->editIndex = $index;
        $this->workEmp = $this->workExperienceData[$index]['workEmp'];
        $this->workPositionId = $this->workExperienceData[$index]['workPositionId'];
        $this->workPositionTitle = $this->workExperienceData[$index]['workPositionTitle'];
        $this->workStatus = $this->workExperienceData[$index]['workStatus'];
        $this->workAdd = $this->workExperienceData[$index]['workAdd'];
        $this->workStart = $this->workExperienceData[$index]['workStart'];
        $this->workEnd = $this->workExperienceData[$index]['workEnd'];

        $this->dispatch('open-modal', 'work-experience-modal');
    }

    public function selectWorkPosition($id)
    {
        $job_position = Job_Positions::findOrFail($id);

        if ($job_position) {
            $this->workPositionId = $id;
            $this->workPositionTitle = $job_position->position_Title;
        }

    }

    public function close()
    {
        $this->resetValidation();
        $this->reset('search', 'workEmp', 'workAdd', 'workPositionId', 'workPositionTitle', 'workStart', 'workEnd', 'workStatus', 'editIndex');
        $this->dispatch('close-modal', 'work-experience-modal');
    }

    public function render()
    {

        $job_positions = Job_Positions::where('position_Status', 1)->where('position_Title', 'like', '%' . $this->search . '%')->get();

        return view('livewire.modals.work-experience-modal', compact('job_positions'));
    }
}
