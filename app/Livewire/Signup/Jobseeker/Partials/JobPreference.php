<?php

namespace App\Livewire\Signup\Jobseeker\Partials;

use App\Models\Job_Industry;
use App\Models\Job_Positions;
use Livewire\Attributes\On;
use Livewire\Component;

class JobPreference extends Component
{

    public $jobpreference = [], $industrypreference = [];

    public $stepNumber = 4;

    #[On('positionSelect')]
    public function positionSelect($id)
    { // Check if the selected job position already exists in the $jobTags array
        if (collect($this->jobpreference)->contains('position_id', $id)) {
            toastr()->warning('This job position is already selected.');
            return;
        }

        $totalTags = count($this->jobpreference);

        if ($totalTags >= 12) {
            toastr()->error('You can only have a maximum of 12 tags.');
            return;
        }

        // If the job position does not exist in the array, add it
        $jobposition = Job_Positions::find($id);

        if ($jobposition) {
            $this->jobpreference[] = [
                'position_id' => $jobposition->position_id,
                'position_Title' => $jobposition->position_Title,
            ];
            $this->dispatch('close-modal', 'job-position-modal');
        } else {
            toastr()->error('Could not fetch data');
            $this->dispatch('close-modal', 'job-position-modal');
        }

    }

    #[On('industrySelect')]
    public function industrySelect($id)
    { // Check if the selected job position already exists in the $jobTags array
        if (collect($this->industrypreference)->contains('industry_id', $id)) {
            toastr()->warning('This industry is already selected.');
            return;
        }

        if (count($this->industrypreference) >= 3) {
            toastr()->warning('You can only choose three industry.');
            $this->dispatch('close-modal', 'industry-modal');
            return;
        }

        // If the job position does not exist in the array, add it
        $industry = Job_Industry::find($id);

        if ($industry) {
            $this->industrypreference[] = [
                'industry_id' => $industry->industry_id,
                'industry_Title' => $industry->industry_Title,
            ];
            $this->dispatch('close-modal', 'industry-modal');
        } else {
            toastr()->error('Could not fetch data');
            $this->dispatch('close-modal', 'industry-modal');
        }

    }

    public function removePosition($positionId)
    {
        // Find the index of the element with the given position_id
        $index = array_search($positionId, array_column($this->jobpreference, 'position_id'));

        // If the element exists in the array, remove it
        if ($index !== false) {
            unset($this->jobpreference[$index]);
            // Reindex the array to maintain sequential keys
            $this->jobpreference = array_values($this->jobpreference);
        }
    }

    public function removeIndustry($industryId)
    {
        // Find the index of the element with the given position_id
        $index = array_search($industryId, array_column($this->industrypreference, 'industry_id'));

        // If the element exists in the array, remove it
        if ($index !== false) {
            unset($this->industrypreference[$index]);
            // Reindex the array to maintain sequential keys
            $this->industrypreference = array_values($this->industrypreference);
        }
    }

    public function next()
    {
        $this->validate([
            'jobpreference' => 'required|array|min:1',
            'industrypreference' => 'required|array|max:1|min:1',
        ], [
            'jobpreference.required' => 'Please select at least one job preference.',
            'jobpreference.array' => 'The job preference must be an array.',
            'jobpreference.min' => 'Please select at least one job preference.',

            'industrypreference.required' => 'Please select at least one industry preference.',
            'industrypreference.array' => 'The industry preference must be an array.',
            'industrypreference.min' => 'Please select at least one industry preference.',
            'industrypreference.max' => 'Please select only one industry preference.',
        ]);

        $this->dispatch('handleStepData', $this->stepNumber, [
            'jobpreference' => $this->jobpreference,
            'industrypreference' => $this->industrypreference,
        ]);

        $this->dispatch('nextStep', $this->stepNumber + 1);
    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);
    }

    public function render()
    {
        return view('livewire.signup.jobseeker.partials.job-preference');
    }
}
