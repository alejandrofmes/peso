<?php

namespace App\Livewire\Admin\Training;

use App\Mail\ProgramCancelReminder;
use App\Models\Employee;
use App\Models\Programs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class TrainingDetails extends Component
{

    public $id;

    public $agreeBox = false;

    public function mount()
    {
        $user = Auth::user();

        $programInfo = Programs::findOrFail($this->id);

        if ($programInfo) {
            if ($user->peso_accounts->peso_id != $programInfo->peso_id) {
                return $this->redirectRoute('dashboard');
            }
        } else {
            return $this->redirectRoute('dashboard');
        }

    }

    public function editTraining($id)
    {
        session()->put('programData', $this->id);

        $this->redirectRoute('admin-edit-training', navigate:true);

    }

    public function getMatched($programInfo)
    {
        $programMunicipalityId = $programInfo->peso->municipality_id;
        $jobIndustryId = $programInfo->industry_id;
        $jobTagIds = $programInfo->program_tags->pluck('position_id');

        return Employee::whereHas('barangay.municipality', function ($query) use ($programMunicipalityId) {
            $query->where('municipality_id', $programMunicipalityId);
        })
            ->whereHas('job_preference', function ($query) use ($jobTagIds) {
                $query->whereIn('position_id', $jobTagIds);
            })
            ->withCount(['job_preference as num_matched_tags' => function ($query) use ($jobTagIds) {
                $query->whereIn('position_id', $jobTagIds);
            }])
            ->withCount(['industry_preference as num_matched_industry' => function ($query) use ($jobIndustryId) {
                $query->where('industry_id', $jobIndustryId);
            }])
            ->orderByRaw('
                CASE
                    WHEN num_matched_industry > 0 AND num_matched_tags > 0 THEN 1
                    WHEN num_matched_industry > 0 AND num_matched_tags = 0 THEN 2
                    WHEN num_matched_industry = 0 AND num_matched_tags > 0 THEN 3
                    ELSE 4
                END
            ')
            ->orderByDesc('num_matched_tags')
            ->get();
    }

    public function cancelProgram()
    {
        $rules = [
            'agreeBox' => 'required|boolean',
        ];
        $messages = [
            'agreeBox.required' => 'Please check the confirmation box before you continue.',
        ];
        $this->validate($rules, $messages);

        DB::beginTransaction();

        try {
            $program = Programs::findOrFail($this->id);

            if ($program) {
                // Update program status
                $program->program_Status = "CANCELLED";
                $program->save();

                // Send notification to registered users

            }

            // Commit the transaction
            DB::commit();

            $registeredUsers = $program->program_reg;
            if ($registeredUsers) {
                foreach ($registeredUsers as $jobseeker) {
                    // Notify each user via email (assuming you have a mailable for this)
                    Mail::to($jobseeker->employee->user->email)->queue(new ProgramCancelReminder($jobseeker->employee, $program));
                }

                // Success message
                toastr()->success('Program has been cancelled. Registered users will be notified via email.');
            }

        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Log the error for debugging (optional)
            Log::error('Error cancelling program: ' . $e->getMessage());

            // Display error message
            toastr()->error('There was an error updating the program. Please try again later.');
        }

        // Reset the checkbox and close the modal
        $this->agreeBox = false;
        $this->dispatch('close-modal', 'cancel-modal');
    }

    public function render()
    {
        $matchingEmployees = null;

        $programInfo = Programs::findOrFail($this->id);

        if ($programInfo) {

            $matchingEmployees = $this->getMatched($programInfo);
        }

        return view('livewire.admin.training.training-details', compact('programInfo', 'matchingEmployees'));
    }
}
