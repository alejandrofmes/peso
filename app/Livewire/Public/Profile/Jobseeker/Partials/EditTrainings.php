<?php

namespace App\Livewire\Public\Profile\Jobseeker\Partials;

use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditTrainings extends Component
{
    // training-modal
    public $trainName, $trainStart, $trainEnd, $trainInstitution, $trainCert, $trainStat, $trainingID;
    public $userID;

    public $deleteTraining;

    public function deleteData($id)
    {
        $this->reset('deleteTraining');
        $this->deleteTraining = $id;
        $this->dispatch('open-modal', 'delete-training-modal');
    }

    public function deleteRecord()
    {
        // Fetch the education record to delete
        $training = Training::findOrFail($this->deleteTraining);

        // Check if the user has only one education record

        DB::beginTransaction();

        try {
            // Perform the deletion
            $training->delete();

            // Commit the transaction if everything is successful
            DB::commit();

            // Optionally, close any modals or provide a success message
            $this->dispatch('close-modal', 'delete-training-modal');
            toastr()->success('Training record has been successfully deleted!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            toastr()->error('There was an error while deleting the training record. Please try again later.');
        }

        // Optionally, reset variables or state after the operation
        $this->reset('deleteTraining');
        $this->dispatch('close-modal', 'delete-training-modal');
    }

    public function save()
    {
        // Define validation rules
        $rules = [
            'trainName' => 'required|string|max:255',
            'trainInstitution' => 'required|string|max:255',
            'trainCert' => 'required|string|max:255',
            'trainStart' => [
                'required',
                'date',
                'before_or_equal:today', // Ensure training start date is not in the future
            ],
            'trainEnd' => [
                'nullable',
                'date',
                'before_or_equal:today', // Ensure training end date is not in the future
                'after_or_equal:trainStart', // Ensure training end date is after or equal to start date
            ],
            'trainStat' => 'required|string|max:255',
        ];

        $messages = [
            'trainName.required' => 'The training name is required.',
            'trainName.string' => 'The training name must be a string.',
            'trainName.max' => 'The training name must not exceed 255 characters.',
            'trainInstitution.required' => 'The training institution is required.',
            'trainInstitution.string' => 'The training institution must be a string.',
            'trainInstitution.max' => 'The training institution must not exceed 255 characters.',
            'trainCert.required' => 'The training certificate is required.',
            'trainCert.string' => 'The training certificate must be a string.',
            'trainCert.max' => 'The training certificate must not exceed 255 characters.',
            'trainStart.required' => 'The training start date is required.',
            'trainStart.date' => 'The training start date must be a valid date.',
            'trainStart.before_or_equal' => 'The training start date must be a date before or equal to today.',
            'trainEnd.date' => 'The training end date must be a valid date.',
            'trainEnd.before_or_equal' => 'The training end date must be a date before or equal to today.',
            'trainEnd.after_or_equal' => 'The training end date must be a date after or equal to the start date.',
            'trainStat.required' => 'The training status is required.',
            'trainStat.string' => 'The training status must be a string.',
            'trainStat.max' => 'The training status must not exceed 255 characters.',
        ];

        // Validate input
        $this->validate($rules, $messages);

        DB::beginTransaction(); // Start transaction

        try {
            if ($this->trainingID) {
                // Update existing record using Eloquent
                $training = Training::find($this->trainingID);

                if ($training) {
                    // Set attributes
                    $training->training_Name = ucwords(strtolower($this->trainName));
                    $training->training_From = $this->trainInstitution;
                    $training->training_Cert = ucwords(strtolower($this->trainCert));
                    $training->training_Start = Carbon::parse($this->trainStart)->format('Y-m-d');
                    $training->training_End = $this->trainEnd ? Carbon::parse($this->trainEnd)->format('Y-m-d') : null;
                    $training->training_Status = $this->trainStat;

                    // Check if any attributes are dirty
                    if ($training->isDirty()) {
                        $training->save();
                        toastr()->success('Training Record has been Updated!');
                    } else {
                        toastr()->info('No changes detected. Training Record remains the same.');
                    }
                } else {
                    toastr()->error('Training record not found.');
                }
            } else {
                // Create new record
                Training::create([
                    'employee_id' => $this->userID,
                    'training_Name' => ucwords(strtolower($this->trainName)),
                    'training_From' => $this->trainInstitution,
                    'training_Cert' => ucwords(strtolower($this->trainCert)),
                    'training_Start' => Carbon::parse($this->trainStart)->format('Y-m-d'),
                    'training_End' => $this->trainEnd ? Carbon::parse($this->trainEnd)->format('Y-m-d') : null,
                    'training_Status' => $this->trainStat,
                ]);

                toastr()->success('New Training Record Created!');
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
        $this->trainingID = $id;
        $training = Training::find($id);

        $this->trainName = $training->training_Name;
        $this->trainInstitution = $training->training_From;
        $this->trainCert = $training->training_Cert;
        $this->trainStart = Carbon::parse($training->training_Start)->format('Y-m-d');
        $this->trainEnd = Carbon::parse($training->training_End)->format('Y-m-d');
        $this->trainStat = $training->training_Status;

        $this->dispatch('open-modal', 'training-modal');

    }

    public function addModal()
    {
        $this->reset('trainName', 'trainStart', 'trainEnd', 'trainInstitution', 'trainCert', 'trainStat', 'trainingID');
        $this->dispatch('open-modal', 'training-modal');

    }

    public function close()
    {
        $this->reset('trainName', 'trainStart', 'trainEnd', 'trainInstitution', 'trainCert', 'trainStat', 'trainingID');
        $this->dispatch('close-modal', 'training-modal');
    }

    public function render()
    {
        $trainings = Training::where('employee_id', '=', $this->userID)
            ->orderBy('training_Start', 'desc')
            ->get();
        return view('livewire.public.profile.jobseeker.partials.edit-trainings', compact('trainings'));
    }
}
