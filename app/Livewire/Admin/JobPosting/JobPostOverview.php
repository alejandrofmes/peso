<?php

namespace App\Livewire\Admin\JobPosting;

use App\Mail\JobPostApplicationNotification;
use App\Mail\JobpostCancelledNotification;
use App\Mail\JobPostingNotification;
use App\Models\Employee;
use App\Models\Job_Posting;
use App\Models\Requirements;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class JobPostOverview extends Component
{

    public $id;

    public $remarks, $cancelRemarks;

    public $eduLevels = [
        '0' => 'NONE',
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

    public $jobTypes = [
        '0' => 'None',
        '1' => 'Full Time',
        '2' => 'Contractual',
        '3' => 'Part Time',
        '4' => 'Project-Based',
        '5' => 'Internship/OJT',
        '6' => 'Work From Home',
    ];

    public $selectedReqPassedId;

    public $cancelJob, $rejectJob, $approveJob;

    public function mount()
    {
        $user = Auth::user();

        $jobpost = Job_Posting::findOrFail($this->id);

        if ($jobpost) {
            if ($user->peso_accounts->peso_id != $jobpost->peso_id) {
                return $this->redirectRoute('dashboard');

            }
        } else {
            return $this->redirectRoute('dashboard');

        }

        $this->cancelJob = false;
        $this->rejectJob = false;
        $this->approveJob = false;

    }

    public function viewFile($reqPassedId)
    {
        $this->selectedReqPassedId = $reqPassedId;

        $url = route('view.requirement');
        // Dispatch an event to trigger JavaScript for opening a new tab
        $this->dispatch('viewFile', [
            'url' => $url,
            'req_passed_id' => $reqPassedId,

        ]);

    }
    public function updateJob($id, $status, $modal)
    {
        $user = Auth::user();

        // Validate the input
        $this->validate([
            'remarks' => 'required|string',
        ]);

        // Initialize variables
        $jobPosting = null;
        $matchingEmployees = [];

        // Begin a transaction
        DB::beginTransaction();

        try {
            // Find and update the job posting
            $jobPosting = Job_Posting::where('job_id', $id)->firstOrFail();

            $jobPosting->update([
                'job_Status' => $status,
                'peso_Remarks' => $this->remarks,
                'peso_id' => $user->peso_accounts->peso_accounts_id,
                'responded_at' => now(),
            ]);

            // If the status is ACTIVE, get the matching employees
            if ($status == 'ACTIVE') {
                $matchingEmployees = $this->getMatched($jobPosting);
            }

            // Commit the transaction
            DB::commit();

            // Send email notification to the company
            Mail::to($jobPosting->company->user->email)
                ->queue(new JobPostApplicationNotification($jobPosting));

        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Log the error for debugging
            Log::error('Job update failed', ['error' => $e->getMessage()]);

            // Show an error message
            toastr()->error('An error occurred while updating the job posting.');
            return;
        }

        // Send emails if the status is ACTIVE and the transaction was committed
        if ($status == 'ACTIVE' && !empty($matchingEmployees)) {
            foreach ($matchingEmployees as $employee) {
                Mail::to($employee->user->email)
                    ->queue(new JobPostingNotification($employee, $jobPosting));
            }
        }

        // Dispatch the event to close the modal
        $this->dispatch('close-modal', $modal);

        // Show a success message depending on the status
        if ($status === 'ACTIVE') {
            toastr()->success('Job Posting Approved');
        } elseif ($status === 'REJECTED') {
            toastr()->success('Job Posting Rejected');
        }
    }

    public function cancelJobPost()
    {
        // dd('hello');
        $user = Auth::user();

        // Validate the input
        $this->validate(
            [
                'cancelRemarks' => 'required|string',
            ],
            [
                'cancelRemarks.required' => 'The cancellation remarks are required.',
                'cancelRemarks.string' => 'The cancellation remarks must be a valid string.',
            ]
        );

        DB::beginTransaction();

        try {
            // Find and update the job posting
            $jobPosting = Job_Posting::findOrFail($this->id);

            $jobPosting->update([
                'job_Status' => 'CANCELLED',
                'peso_Remarks' => $this->cancelRemarks,
                'peso_id' => $user->peso_accounts->peso_accounts_id,

            ]);

            Artisan::call('app:cancel-job-posting', [
                'jobId' => $this->id,
            ]);
            DB::commit();
            Mail::to($jobPosting->company->user->email)
                ->queue(new JobpostCancelledNotification($jobPosting));
            $this->dispatch('close-modal', 'cancel-modal');
            toastr()->success('Job Posting Cancelled');

        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();
            dd($e->getMessage());

            // Log the error for debugging
            Log::error('Job update failed', ['error' => $e->getMessage()]);

            // Show an error message
            toastr()->error('An error occurred while updating the job posting.');
            return;
        }

    }

    public function close($modal)
    {
        $this->reset('remarks');
        $this->resetValidation();
        $this->dispatch('close-modal', $modal);
        $this->cancelJob = false;
        $this->rejectJob = false;
        $this->approveJob = false;
    }

    public function getMatched($jobpost)
    {
        // Get job posting details
        $jobMunicipalityId = $jobpost->peso->municipality_id;
        $jobEducationLevel = $jobpost->job_Edu;
        $jobIndustryId = $jobpost->industry_id;
        $jobTagIds = $jobpost->job_tags->pluck('position_id')->toArray();

        // Build the query to get matched employees
        return Employee::whereHas('user', function ($query) {
            $query->where('userstatus', 1); // Ensure userstatus == 1
        })
            ->whereHas('barangay.municipality', function ($query) use ($jobMunicipalityId) {
                $query->where('municipality_id', $jobMunicipalityId);
            })
            ->whereHas('education', function ($query) use ($jobEducationLevel) {
                $query->where('edu_Level', '>=', $jobEducationLevel);
            })
            ->where(function ($query) use ($jobTagIds, $jobIndustryId) {
                // Broad matching: either job preferences or industry preference, or both
                $query->whereHas('job_preference', function ($query) use ($jobTagIds) {
                    $query->whereIn('position_id', $jobTagIds);
                })
                    ->orWhereHas('industry_preference', function ($query) use ($jobIndustryId) {
                        if ($jobIndustryId) {
                            $query->where('industry_id', $jobIndustryId);
                        }
                    });
            })
            ->withCount(['job_preference as num_matched_tags' => function ($query) use ($jobTagIds) {
                $query->whereIn('position_id', $jobTagIds);
            }])
            ->withCount(['industry_preference as num_matched_industry' => function ($query) use ($jobIndustryId) {
                if ($jobIndustryId) {
                    $query->where('industry_id', $jobIndustryId);
                }
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

    public function render()
    {
        $user = Auth::user();

        $jobpost = Job_Posting::with(['job_tags'])->findOrFail($this->id);

        if ($user->peso_accounts->peso_id != $jobpost->peso_id) {
            return redirect()->back();
        }
        $matchingEmployees = $this->getMatched($jobpost);

        $requirements = Requirements::with([
            'requirementPassed' => function ($query) use ($jobpost) {
                $query->where('company_id', $jobpost->company_id); // Use `where` for filtering
            },
        ])
            ->where('requirement_Status', 1)
            ->where('requirement_Type', $jobpost->company->employer_Type)

            ->get();

        return view('livewire.admin.job-posting.job-post-overview', compact('jobpost', 'matchingEmployees', 'requirements'));
    }
}
