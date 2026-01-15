<?php

namespace App\Livewire\Jobseeker;

use App\Mail\ApplicationAccepted;
use App\Mail\ApplicationCompleted;
use App\Models\Employee;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ApplicationHistory extends Component
{

    use WithPagination, WithoutUrlPagination;
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
    public $selectedJob;
    public $search, $filter = 'All', $sort = 'Newest';

    public $acceptBox = false, $rejectBox = false;

    public function handleResponse($status, $id)
    {
        $user = Auth::user();

        // Fetch the applicant record based on job_id and employee_id
        $applicant = Job_Applicants::find($id);

        // Check if an applicant record was found
        if ($applicant) {
            DB::beginTransaction();

            try {
                // Update the applicant's status
                $applicant->update([
                    'applicant_Status' => $status,
                ]);

                if ($status == 'ACCEPTED') {
                    // Check and update employee status if necessary
                    if ($user->employee->empstatus == 2) { // Assuming empstatus is stored as an integer
                        $employee = Employee::find($applicant->employee->employee_id);
                        $employee->update([
                            'empstatus' => 1,
                            'empstatusdesc' => 1,
                        ]);
                    }
                    Mail::to($applicant->employee->user->email)
                        ->queue(new ApplicationCompleted($applicant));
                    Mail::to($applicant->job_posting->company->user->email)
                        ->queue(new ApplicationAccepted($applicant));

                    // Check remaining slots in the job posting
                    $jobPosting = Job_Posting::find($applicant->job_id);

                    if ($jobPosting && $jobPosting->slotsLeft() <= 0) {
                        // Dispatch the command to handle the job posting closure and notifications
                        Artisan::call('jobposting:process', ['jobId' => $applicant->job_id]);

                    }

                    // Commit the transaction
                    DB::commit();

                    // Show success toastr notification
                    $this->dispatch('close-modal', 'accept-modal');
                    toastr()->success('Congratulations, job has been accepted!');

                } elseif ($status == 'CANCELLED') {
                    // Commit the transaction
                    DB::commit();

                    // Show error toastr notification
                    $this->dispatch('close-modal', 'reject-modal');
                    toastr()->error('Job has been rejected!');
                }
            } catch (\Exception $e) {
                // Rollback the transaction if an error occurs
                DB::rollBack();

                toastr()->error($e->getMessage());
                // Optionally, log the exception
                Log::error('Error handling response: ' . $e->getMessage());
            }
        } else {
            // Show error toastr notification if applicant record not found
            toastr()->error('Error in updating, please try again later.');
        }
    }

    public function updateSelection($id)
    {
        $this->selectedJob = $id;

        $applicantNotif = Job_Applicants::findOrFail($id);

        if ($applicantNotif->applicant_Notif == 1) {
            $applicantNotif->update(['applicant_Notif' => 2]);
        }
    }

    public function updateFilter($value)
    {
        $this->filter = $value;
    }

    public function updateSort($value)
    {
        $this->sort = $value;
    }

    public function viewFile($id, $fileToView)
    {

        if ($fileToView === 3) {

            $this->dispatch('viewFile', [
                'url' => route('view.recommendation'),
                'app_id' => $id,
            ]);

        } else {

            $this->dispatch('viewFile', [
                'url' => route('view.resume'),
                'emp_id' => $id,
                'resume_type' => $fileToView,
            ]);
        }

    }
    public function render()
    {
        $user = Auth::user(); // Correct usage of the Auth facade

        $applications = Job_Applicants::with(['job_posting.company'])
            ->where('employee_id', '=', $user->employee->employee_id)
            ->where(function ($query) {
                $query->whereHas('job_posting', function ($query) {
                    $query->where('job_Title', 'like', '%' . $this->search . '%');
                })

                    ->orWhereHas('job_posting.company', function ($query) {
                        $query->where('business_Name', 'like', '%' . $this->search . '%');
                    });
            });

        if ($this->filter == 'Pending') {
            $applications = $applications->whereIn('applicant_Status', ['PENDING', 'INTERESTED']);
        } else if ($this->filter == 'Interview') {
            $applications = $applications->where('applicant_Status', 'INTERVIEW');
        } else if ($this->filter == 'Others') {
            $applications = $applications->whereNotIn('applicant_Status', ['INTERVIEW', 'PENDING', 'INTERESTED']);
        }

        if ($this->sort == 'Newest') {
            $applications = $applications->orderBy('created_at', 'DESC');
        } else if ($this->sort == 'Oldest') {
            $applications = $applications->orderBy('created_at', 'ASC');

        }

        $applications = $applications->paginate(5);
        $applicationInfo = null;
        if ($this->selectedJob) {
            $applicationInfo = Job_Applicants::find($this->selectedJob);
        }
        return view('livewire.jobseeker.application-history', compact('applications', 'applicationInfo'));
    }
}
