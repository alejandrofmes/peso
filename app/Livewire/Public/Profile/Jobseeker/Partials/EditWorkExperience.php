<?php

namespace App\Livewire\Public\Profile\Jobseeker\Partials;

use App\Models\Job_Positions;
use App\Models\Work_Exp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditWorkExperience extends Component
{

    public $workName, $workPosition, $workPositionTitle, $workStatus = "", $workAdd, $workStart, $workEnd, $workID;
    public $userID;

    public $search;

    public $deleteWork;

    public function deleteData($id)
    {
        $this->reset('deleteWork');
        $this->deleteWork = $id;
        $this->dispatch('open-modal', 'delete-workExp-modal');
    }

    public function deleteRecord()
    {
        // Fetch the education record to delete
        $workExp = Work_Exp::findOrFail($this->deleteWork);

        // Check if the user has only one education record

        DB::beginTransaction();

        try {
            // Perform the deletion
            $workExp->delete();

            // Commit the transaction if everything is successful
            DB::commit();

            // Optionally, close any modals or provide a success message
            $this->dispatch('close-modal', 'delete-workExp-modal');
            toastr()->success('Work experience has been successfully deleted!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            toastr()->error('There was an error while deleting the work experience. Please try again later.');
        }

        // Optionally, reset variables or state after the operation
        $this->reset('deleteWork');
        $this->dispatch('close-modal', 'delete-workExp-modal');
    }
    public function updateSelect($id)
    {

        $selectedPosition = Job_Positions::find($id);

        if ($selectedPosition) {
            $this->workPosition = $id;
            $this->workPositionTitle = $selectedPosition->position_Title;
        }

    }

    public function save()
    {
        // Validation rules and messages
        $rules = [
            'workName' => ['required', 'string'],
            'workAdd' => ['required', 'string'],
            'workPosition' => ['required', 'integer'],
            'workStart' => ['required', 'date', 'before_or_equal:today'],
            'workEnd' => ['nullable', 'date', 'after_or_equal:workStart'],
            'workStatus' => ['required', 'string'],
        ];

        $messages = [
            'workName.required' => 'The company name is required.',
            'workName.string' => 'The company name must be a string.',
            'workAdd.required' => 'The address is required.',
            'workAdd.string' => 'The address must be a string.',
            'workPosition.required' => 'The position is required.',
            'workPosition.integer' => 'The position must be an integer.',
            'workStart.required' => 'The start date is required.',
            'workStart.date' => 'The start date must be a valid date.',
            'workStart.before_or_equal' => 'The start date must be today or before.',
            'workEnd.date' => 'The end date must be a valid date.',
            'workEnd.after_or_equal' => 'The end date must be today or after the start date.',
            'workStatus.required' => 'The status is required.',
            'workStatus.string' => 'The status must be a string.',
        ];

        $this->validate($rules, $messages);

        DB::beginTransaction(); // Start transaction

        try {
            if ($this->workID) {
                // Update existing record using Eloquent
                $workExp = Work_Exp::find($this->workID);

                if ($workExp) {
                    $workExp->work_Name = $this->workName;
                    $workExp->work_Address = $this->workAdd;
                    $workExp->position_id = $this->workPosition;
                    $workExp->work_Start = Carbon::parse($this->workStart)->format('Y-m-d');
                    $workExp->work_End = $this->workEnd ? Carbon::parse($this->workEnd)->format('Y-m-d') : null;
                    $workExp->work_Status = $this->workStatus;

                    if ($workExp->isDirty()) {
                        $workExp->save();
                        toastr()->success('Work Experience Record has been Updated!');
                    } else {
                        toastr()->info('No changes detected. Work Experience Record remains the same.');
                    }
                } else {
                    toastr()->error('Work experience record not found.');
                }
            } else {
                // Create new record
                Work_Exp::create([
                    'employee_id' => $this->userID,
                    'work_Name' => $this->workName,
                    'work_Address' => $this->workAdd,
                    'position_id' => $this->workPosition,
                    'work_Start' => Carbon::parse($this->workStart)->format('Y-m-d'),
                    'work_End' => $this->workEnd ? Carbon::parse($this->workEnd)->format('Y-m-d') : null,
                    'work_Status' => $this->workStatus,
                ]);

                toastr()->success('New Work Experience Record Created!');
            }

            DB::commit(); // Commit transaction
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on failure
            toastr()->error('There was an error, please try again later.');

        }

        $this->close();
        $this->dispatch('reload-table');
    }

    public function editModal($id)
    {
        $this->resetValidation();
        $this->workID = $id;
        $work = Work_Exp::find($id);
        $this->workName = $work->work_Name;
        $this->workAdd = $work->work_Address;
        $this->workPosition = $work->position_id;
        $this->workPositionTitle = $work->job_positions->position_Title;
        $this->workStatus = $work->work_Status;
        $this->workStart = Carbon::parse($work->work_Start)->format('Y-m-d');
        $this->workEnd = Carbon::parse($work->work_End)->format('Y-m-d');

        $this->dispatch('open-modal', 'workExp-modal');
    }

    public function addModal()
    {
        $this->resetValidation();
        $this->reset('search', 'workName', 'workAdd', 'workPosition', 'workStart', 'workEnd', 'workStatus', 'workID', 'workPositionTitle');
        $this->dispatch('open-modal', 'workExp-modal');
    }

    public function close()
    {
        $this->resetValidation();
        $this->reset('search', 'workName', 'workAdd', 'workPosition', 'workStart', 'workEnd', 'workStatus', 'workID', 'workPositionTitle');
        $this->dispatch('close-modal', 'workExp-modal');
    }

    public function render()
    {
        $workexp = Work_Exp::where('employee_id', '=', $this->userID)
            ->orderBy('work_Start', 'desc')
            ->get();
        $job_positions = Job_Positions::where('position_Status', 1)->where('position_Title', 'like', '%' . $this->search . '%')->get();

        return view('livewire.public.profile.jobseeker.partials.edit-work-experience', compact('workexp', 'job_positions'));
    }
}
