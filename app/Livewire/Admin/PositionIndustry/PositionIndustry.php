<?php

namespace App\Livewire\Admin\PositionIndustry;

use App\Models\Job_Industry;
use App\Models\Job_Positions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class PositionIndustry extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $rows = 10;

    public $searchIndustry, $searchPosition;

    public $positionPost, $pcodePost, $positionID;

    public $industryPost, $icodePost, $industryID;

    public $archiveJob, $archiveIndustry;
    public $restoreJob, $restoreIndustry;

    public $filterJob = 'All', $filterIndustry = 'All';

    public function updatedsearchIndustry()
    {
        $this->resetPage('industry'); // Reset pagination for eligibility search
    }

    // Listen for updates to the searchLicense variable
    public function updatedsearchPosition()
    {
        $this->resetPage('position'); // Reset pagination for license search
    }

    public function updateFilter($type, $value)
    {
        if ($type == 1) {
            $this->filterJob = $value;
            $this->resetPage('position');
        } elseif ($type == 2) {
            $this->filterIndustry = $value;
            $this->resetPage('industry');

        }
    }

    public function archiveConfirmation($type, $id)
    {
        $this->reset('archiveJob', 'archiveIndustry');
        if ($type == 1) {
            $this->archiveJob = $id;
            $this->dispatch('open-modal', 'delete-jobposition-modal');

        } elseif ($type == 2) {
            $this->archiveIndustry = $id;
            $this->dispatch('open-modal', 'delete-industry-modal');

        } else {
            toastr()->error('There was an error. Please try again later.');
        }
    }

    public function confirmArchive($type)
    {
        DB::beginTransaction();

        try {
            if ($type == 1) {
                $position = Job_Positions::findOrFail($this->archiveJob);
                $position->position_Status = 2;
                $position->save();

                $this->dispatch('close-modal', 'delete-jobposition-modal');
                toastr()->success('Job Position was successfully archived!');
            } elseif ($type == 2) {
                $industry = Job_Industry::findOrFail($this->archiveIndustry);
                $industry->industry_Status = 2;
                $industry->save();

                $this->dispatch('close-modal', 'delete-industry-modal');
                toastr()->success('Job Industry was successfully archived!');
            } else {
                toastr()->error('Invalid archive type. Please try again.');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('There was an error. Please try again later.');
            // Log the exception if necessary
            Log::error('Error archiving: ' . $e->getMessage());
        }
    }

    public function restoreConfirmation($type, $id)
    {
        $this->reset('restoreJob', 'restoreIndustry');
        if ($type == 1) {
            $this->restoreJob = $id;
            $this->dispatch('open-modal', 'restore-jobposition-modal');

        } elseif ($type == 2) {
            $this->restoreIndustry = $id;
            $this->dispatch('open-modal', 'restore-industry-modal');

        } else {
            toastr()->error('There was an error. Please try again later.');
        }
    }

    public function confirmRestore($type)
    {
        DB::beginTransaction();

        try {
            if ($type == 1) {
                $position = Job_Positions::findOrFail($this->restoreJob);
                $position->position_Status = 1;
                $position->save();

                $this->dispatch('close-modal', 'restore-jobposition-modal');
                toastr()->success('Job Position was successfully restored!');
            } elseif ($type == 2) {
                $industry = Job_Industry::findOrFail($this->restoreIndustry);
                $industry->industry_Status = 1;
                $industry->save();

                $this->dispatch('close-modal', 'restore-industry-modal');
                toastr()->success('Job Industry was successfully restored!');
            } else {
                toastr()->error('Invalid archive type. Please try again.');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('There was an error. Please try again later.');
            // Log the exception if necessary
            Log::error('Error archiving: ' . $e->getMessage());
        }
    }

    public function savePosition()
    {

        if ($this->positionID) {
            $rules = [
                'positionID' => ['required'],
                'pcodePost' => ['required', 'string', Rule::unique('job_positions', 'position_Code')->ignore($this->positionID, 'position_id')],
                'positionPost' => ['required', 'string', Rule::unique('job_positions', 'position_Title')->ignore($this->positionID, 'position_id')],
            ];

            $messages = [
                'positionID.required' => 'The position ID is required.',
                'pcodePost.required' => 'The position code is required.',
                'pcodePost.string' => 'The position code must be a string.',
                'pcodePost.unique' => 'The position code has already been taken.',
                'positionPost.required' => 'The position title is required.',
                'positionPost.string' => 'The position title must be a string.',
                'positionPost.unique' => 'The position title has already been taken.',
            ];

            $this->validate($rules, $messages);
            DB::beginTransaction();

            try {
                $jobPosition = Job_Positions::findOrFail($this->positionID);

                $jobPosition->position_Code = strtoupper($this->pcodePost);
                $jobPosition->position_Title = strtoupper($this->positionPost);
                if ($jobPosition->isDirty()) {
                    $jobPosition->save();
                    toastr()->success('Job Position has been updated!');
                } else {
                    toastr()->info('No changes detected.');
                }
                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error('There was an error updating the job position.');
            }
        } else {
            $rules = [
                'pcodePost' => ['required', 'string', Rule::unique('job_positions', 'position_Code')],
                'positionPost' => ['required', 'string', Rule::unique('job_positions', 'position_Title')],
            ];

            $messages = [
                'pcodePost.required' => 'The position code is required.',
                'pcodePost.string' => 'The position code must be a string.',
                'pcodePost.unique' => 'The position code has already been taken.',
                'positionPost.required' => 'The position title is required.',
                'positionPost.string' => 'The position title must be a string.',
                'positionPost.unique' => 'The position title has already been taken.',
            ];

            $this->validate($rules, $messages);
            DB::beginTransaction();
            try {
                Job_Positions::create([
                    'position_Code' => strtoupper($this->pcodePost),
                    'position_Title' => strtoupper($this->positionPost),
                ]);
                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error('There was an error updating the job position.');
            }
            toastr()->success('Job Position Created!');
        }

        $this->close('jobposition');

    }
    public function editPosition($id)
    {
        $jobposition = Job_Positions::findOrFail($id);

        if ($jobposition) {
            $this->positionID = $jobposition->position_id;
            $this->positionPost = $jobposition->position_Title;
            $this->pcodePost = $jobposition->position_Code;
            $this->dispatch('open-modal', 'jobposition-modal');
        } else {
            toastr()->error('There was an error in finding the data.');
        }
    }

    public function saveIndustry()
    {

        if ($this->industryID) {
            $rules = [
                'industryID' => ['required'],
                'icodePost' => ['required', 'string', Rule::unique('job_industry', 'industry_Code')->ignore($this->industryID, 'industry_id')],
                'industryPost' => ['required', 'string', Rule::unique('job_industry', 'industry_Title')->ignore($this->industryID, 'industry_id')],
            ];

            $messages = [
                'industryID.required' => 'The industry ID is required.',
                'icodePost.required' => 'The industry code is required.',
                'icodePost.string' => 'The industry code must be a string.',
                'icodePost.unique' => 'The industry code has already been taken.',
                'industryPost.required' => 'The industry title is required.',
                'industryPost.string' => 'The industry title must be a string.',
                'industryPost.unique' => 'The industry title has already been taken.',
            ];

            $this->validate($rules, $messages);
            DB::beginTransaction();

            try {
                $industry = Job_Industry::findOrFail($this->industryID);

                $industry->industry_Code = strtoupper($this->icodePost);
                $industry->industry_Title = strtoupper($this->industryPost);
                if ($industry->isDirty()) {
                    $industry->save();
                    toastr()->success('Industry has been updated!');
                } else {
                    toastr()->info('No changes detected.');
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error('There was an error updating the industry.');
            }
        } else {
            $rules = [
                'icodePost' => ['required', 'string', Rule::unique('job_industry', 'industry_Code')],
                'industryPost' => ['required', 'string', Rule::unique('job_industry', 'industry_Title')],
            ];

            $messages = [
                'icodePost.required' => 'The industry code is required.',
                'icodePost.string' => 'The industry code must be a string.',
                'icodePost.unique' => 'The industry code has already been taken.',
                'industryPost.required' => 'The industry title is required.',
                'industryPost.string' => 'The industry title must be a string.',
                'industryPost.unique' => 'The industry title has already been taken.',
            ];

            $this->validate($rules, $messages);
            DB::beginTransaction();

            try {
                Job_Industry::create([
                    'industry_Code' => strtoupper($this->icodePost),
                    'industry_Title' => strtoupper($this->industryPost), // Validate role selection
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error('There was an error updating the industry.');
            }

            toastr()->success('Industry Created!');
        }
        $this->close('industry');

    }

    public function editIndustry($id)
    {
        $industry = Job_Industry::findOrFail($id);

        if ($industry) {
            $this->industryID = $industry->industry_id;
            $this->industryPost = $industry->industry_Title;
            $this->icodePost = $industry->industry_Code;
            $this->dispatch('open-modal', 'industry-modal');
        } else {
            toastr()->error('There was an error in finding the data.');
        }
    }

    public function open($modal)
    {
        $this->reset('positionPost', 'pcodePost', 'positionID', 'industryPost', 'icodePost', 'industryID');

        $this->resetValidation();
        $this->dispatch('open-modal', $modal . '-modal');

    }

    public function close($modal)
    {
        $this->dispatch('close-modal', $modal . '-modal');
        $this->reset('searchIndustry', 'searchPosition', 'positionPost', 'pcodePost', 'positionID', 'industryPost', 'icodePost', 'industryID');
        $this->resetValidation();
    }

    public function render()
    {

        $jobpositionsQuery = Job_Positions::where(function ($query) {
            $query->where('position_Title', 'like', '%' . $this->searchPosition . '%')
                ->orWhere('position_Code', 'like', '%' . $this->searchPosition . '%');
        })
            ->orderBy('position_Title', 'asc');

        $industryQuery = Job_Industry::where(function ($query) {
            $query->where('industry_Title', 'like', '%' . $this->searchIndustry . '%')
                ->orWhere('industry_Code', 'like', '%' . $this->searchIndustry . '%');
        })
            ->orderBy('industry_Title', 'asc');

        if ($this->filterJob == 'All') {
            $jobpositionsQuery->where('position_Status', 1);
        } else if ($this->filterJob == 'Archived') {
            $jobpositionsQuery->where('position_Status', 2);
        }

        if ($this->filterIndustry == 'All') {
            $industryQuery->where('industry_Status', 1);
        } else if ($this->filterIndustry == 'Archived') {
            $industryQuery->where('industry_Status', 2);
        }

        $industry = $industryQuery->orderBy('industry_Title', 'asc')->paginate($this->rows, ['*'], 'industry');
        $jobpositions = $jobpositionsQuery->orderBy('position_Title', 'asc')->paginate($this->rows, ['*'], 'position');

        return view('livewire.admin.position-industry.position-industry', compact('industry', 'jobpositions'));
    }
}
