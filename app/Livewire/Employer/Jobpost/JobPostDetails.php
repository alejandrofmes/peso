<?php

namespace App\Livewire\Employer\Jobpost;

use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class JobPostDetails extends Component
{
    public $id;

    public $eduLevels;

    public $jobTypes;

    public $applicantSearch, $selectedApplicant;

    public $filter = 'All';

    public $sortDate;

    public function mount()
    {
        $this->eduLevels = [
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

        $this->jobTypes = [
            '0' => 'None',
            '1' => 'Full Time',
            '2' => 'Contractual',
            '3' => 'Part Time',
            '4' => 'Project-Based',
            '5' => 'Internship/OJT',
            '6' => 'Work From Home',
        ];

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

    public function changeFilter($filter)
    {
        $this->filter = $filter;
        $this->reset('sortDate');
    }
    public function updateSort($sort)
    {
        $this->sortDate = $sort;

    }
    public function getApplicant($id)
    {
        $this->selectedApplicant = $id;
        $this->reset('sortDate');
    }

    public function render()
    {
        $jobpost = Job_Posting::findOrFail($this->id);
        $applicantInfo = null;

        $applicantsQuery = Job_Applicants::leftJoin('employee', 'job_applicants.employee_id', '=', 'employee.employee_id')
            ->where('job_applicants.job_id', $this->id)
            ->whereNot('job_applicants.peso_Status', 'PENDING')
            ->where(function ($query) {
                $query->where('employee.fname', 'like', '%' . $this->applicantSearch . '%')
                    ->orWhere('employee.mname', 'like', '%' . $this->applicantSearch . '%')
                    ->orWhere('employee.lname', 'like', '%' . $this->applicantSearch . '%');
            });

        // Apply the filter if it's not 'ALL'
        if ($this->filter != 'All') {
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
        $total = Job_Applicants::where('job_id', $this->id)
            ->whereNot('job_applicants.peso_Status', 'PENDING')
            ->count();

        $pending = Job_Applicants::where('job_id', $this->id)->where('job_applicants.applicant_Status', 'pending')->whereNot('job_applicants.peso_Status', 'PENDING')->count();
        $interested = Job_Applicants::where('job_id', $this->id)->where('job_applicants.applicant_Status', 'interested')->whereNot('job_applicants.peso_Status', 'PENDING')->count();
        $interview = Job_Applicants::where('job_id', $this->id)->where('job_applicants.applicant_Status', 'interview')->whereNot('job_applicants.peso_Status', 'PENDING')->count();
        $hired = Job_Applicants::where('job_id', $this->id)->where('job_applicants.applicant_Status', 'hired')->whereNot('job_applicants.peso_Status', 'PENDING')->count();
        $accepted = Job_Applicants::where('job_id', $this->id)->where('job_applicants.applicant_Status', 'accepted')->whereNot('job_applicants.peso_Status', 'PENDING')->count();
        $rejected = Job_Applicants::where('job_id', $this->id)
            ->whereIn('applicant_Status', ['rejected', 'cancelled'])
            ->whereNot('job_applicants.peso_Status', 'PENDING')
            ->count();

        // Get the paginated list of applicants
        $list = $applicantsQuery->paginate(10);
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

        if ($this->selectedApplicant) {
            $applicantInfo = Job_Applicants::find($this->selectedApplicant);

        }

        return view('livewire.employer.jobpost.job-post-details', compact('jobpost', 'applicants', 'applicantInfo'));
    }
}
