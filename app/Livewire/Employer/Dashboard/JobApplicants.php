<?php

namespace App\Livewire\Employer\Dashboard;

use App\Mail\ApplicationNotification;
use App\Models\Company;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

// use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('layouts.app')]
class JobApplicants extends Component
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

    public $remarks, $applicantId;

    public $applicantSearch, $postSearch;
    public $selectedJob, $selectedApplicant;

    public $agreePost;

    public $filter = 'ALL', $sortDate, $jobFilter = 'ALL';

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

    public function openModal($modal, $applicantId)
    {
        $this->reset('remarks', 'applicantId');
        $this->applicantId = $applicantId;
        $this->dispatch('open-modal', $modal . '-modal');
    }
    public function closeModal($modal)
    {
        $this->reset('remarks', 'applicantId');
        $this->dispatch('close-modal', $modal . '-modal');
    }

    public function updateApplicant($status, $modal)
    {
        // Validation rules
        $this->validate([
            'remarks' => ['required', 'string'],
        ]);
    
        DB::beginTransaction(); // Start the transaction
    
        try {
            // Prepare update data
            $updateData = [
                'applicant_Status' => $status,
                'company_Remarks' => $this->remarks,
            ];
    
            // Conditionally add 'applicant_Notif' to the update data
            if ($status != 'INTERESTED') {
                $updateData['applicant_Notif'] = 1;
            }
    
            // Find the applicant record
            $applicant = Job_Applicants::findOrFail($this->applicantId);
    
            // Update the applicant record
            $applicant->update($updateData);
    
            // Send notification email if status is 'INTERVIEW', 'HIRED', or 'REJECTED'
            if (in_array($status, ['INTERVIEW', 'HIRED', 'REJECTED'])) {
                Mail::to($applicant->employee->user->email)->queue(new ApplicationNotification($applicant->employee, $applicant));
            }
    
            DB::commit(); // Commit the transaction
    
            toastr()->success('Applicant has been updated!');
        } catch (ModelNotFoundException $e) {
            DB::rollBack(); // Rollback the transaction if the model is not found
    
            toastr()->error('Applicant not found.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on general exceptions
    
            toastr()->error('There was an error updating the applicant.');
        }
    
        $this->closeModal($modal);
    }
    

    public function getApplicant($id)
    {
        $this->selectedApplicant = $id;
        $this->reset('sortDate');
    }

    public function getJob($id)
    {
        $this->selectedJob = $id;
        $this->reset('sortDate', 'selectedApplicant');
        $this->filter = 'ALL';
        // $this->filter = 'ALL';
        // $this->reset('applicantSearch');

    }

    public function changeFilter($filter)
    {
        $this->filter = $filter;
        $this->reset('sortDate');
    }
    public function updateSort($sort)
    {
        $this->sortDate = $sort;

    }

    public function updateJobFilter($status)
    {
        $this->jobFilter = $status;
    }

    public function render()
    {
        $applicants = null; // Initialize $applicants variable
        $applicantInfo = null;

        if ($this->selectedJob) {
            // Create the initial query for applicants
            $applicantsQuery = Job_Applicants::leftJoin('employee', 'job_applicants.employee_id', '=', 'employee.employee_id')
                ->where('job_applicants.job_id', $this->selectedJob)
                ->whereNot('job_applicants.peso_Status', 'PENDING')
                ->where(function ($query) {
                    $query->where('employee.fname', 'like', '%' . $this->applicantSearch . '%')
                        ->orWhere('employee.mname', 'like', '%' . $this->applicantSearch . '%')
                        ->orWhere('employee.lname', 'like', '%' . $this->applicantSearch . '%');
                });

            // Apply the filter if it's not 'ALL'
            if ($this->filter != 'ALL') {
                if ($this->filter == 'REJECTED') {
                    $applicantsQuery->whereIn('job_applicants.applicant_Status', ['REJECTED', 'CANCELLED']);
                } else {
                    $applicantsQuery->where('job_applicants.applicant_Status', $this->filter);

                }
            }

            if ($this->sortDate !== null && $this->sortDate !== '') {
                $applicantsQuery->orderBy('job_applicants.created_at', $this->sortDate);
            }

            // Get the counts
            $total = Job_Applicants::where('job_id', $this->selectedJob)
                ->whereNot('job_applicants.peso_Status', 'PENDING')
                ->count();

            $pending = Job_Applicants::where('job_id', $this->selectedJob)->where('job_applicants.applicant_Status', 'pending')->whereNot('job_applicants.peso_Status', 'PENDING')->count();
            $interested = Job_Applicants::where('job_id', $this->selectedJob)->where('job_applicants.applicant_Status', 'interested')->whereNot('job_applicants.peso_Status', 'PENDING')->count();
            $interview = Job_Applicants::where('job_id', $this->selectedJob)->where('job_applicants.applicant_Status', 'interview')->whereNot('job_applicants.peso_Status', 'PENDING')->count();
            $hired = Job_Applicants::where('job_id', $this->selectedJob)->where('job_applicants.applicant_Status', 'hired')->whereNot('job_applicants.peso_Status', 'PENDING')->count();
            $accepted = Job_Applicants::where('job_id', $this->selectedJob)->where('job_applicants.applicant_Status', 'accepted')->whereNot('job_applicants.peso_Status', 'PENDING')->count();
            $rejected = Job_Applicants::where('job_id', $this->selectedJob)
                ->whereIn('applicant_Status', ['rejected', 'cancelled'])
                ->whereNot('job_applicants.peso_Status', 'PENDING')
                ->count();

            // Get the paginated list of applicants
            $list = $applicantsQuery->paginate(5);

            // Set the applicants array
            $applicants = [
                'total' => $total,
                'pending' => $pending,
                'interested' => $interested,
                'interview' => $interview,
                'hired' => $hired,
                'accepted' => $accepted,
                'rejected' => $rejected,
                'list' => $list,
            ];
        }

        // Fetch jobs for the authenticated user's company
        $user = Auth::user();
        $userCompanyId = $user->company->company_id;
        $jobsQuery = Job_Posting::withCount(['job_applicants' => function ($query) {
            $query->whereNot('peso_Status', 'PENDING');
        }])
            ->where('company_id', $userCompanyId)
            ->whereIn('job_Status', ['ACTIVE','CLOSED'])
            ->where(function ($query) {
                $query->where('job_Title', 'like', '%' . $this->postSearch . '%');
            });
        if ($this->jobFilter !== 'ALL') {
            $jobsQuery->where('job_Status', $this->jobFilter);
        }

        $jobs = $jobsQuery->paginate(5);

        if ($this->selectedApplicant) {
            $applicantInfo = Job_Applicants::find($this->selectedApplicant);

        }

        return view('livewire.employer.dashboard.job-applicants', compact('jobs', 'applicants', 'applicantInfo'));
    }
}

// if ($this->selectedJob) {
//     // Fetch applicants for the selected job
//     $applicantsQuery = Job_Applicants::leftJoin('employee', 'job_applicants.employee_id', '=', 'employee.employee_id')
//         ->where('job_applicants.job_id', $this->selectedJob)
//         ->where(function ($query) {
//             $query->where('employee.fname', 'like', '%' . $this->applicantSearch . '%')
//                 ->orWhere('employee.mname', 'like', '%' . $this->applicantSearch . '%')
//                 ->orWhere('employee.lname', 'like', '%' . $this->applicantSearch . '%');
//         });

//     if ($this->filter != 'ALL') {
//         $applicantsQuery = $applicantsQuery->where('job_applicants.applicant_Status', '=', $this->filter);
//     }

//     $applicantsQuery = $applicantsQuery->get();

//     $totalApplicants = $applicantsQuery->count();
//     $pendingApplicants = $applicantsQuery->where('status', 'pending')->count();
//     $interestedApplicants = $applicantsQuery->where('status', 'interested')->count();
//     $hiredApplicants = $applicantsQuery->where('status', 'hired')->count();

//     // Store applicant counts together
//     $applicants = [
//         'total' => $totalApplicants,
//         'pending' => $pendingApplicants,
//         'interested' => $interestedApplicants,
//         'hired' => $hiredApplicants,
//         'list' => $applicantsQuery,
//     ];
// }
