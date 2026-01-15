<?php

namespace App\Livewire\Admin\JobPosting\Applicants;

use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelWriter;

#[Layout('layouts.admin')]
class JobPostApplicants extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $id;

    public $search;
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
    }

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
    public function updatedsearch()
    {
        $this->resetPage();
    }

    public function exportData()
    {

        $jobApplicants = $this->getApplicants($this->id)->get();

        if (!$jobApplicants->isEmpty()) {

            $fileName = $jobApplicants->first()->job_id . '-job_applicants-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

            $writer = SimpleExcelWriter::streamDownload($fileName);

            foreach ($jobApplicants as $data) {
                $writer->addRow([
                    'Last Name' => $data->employee->lname,
                    'First Name' => $data->employee->mname,
                    'Middle Name' => $data->employee->fname,
                    'Status' => $data->applicant_Status,
                    'Date Applied' => $data->created_at->format('F j, Y'),
                    'PESO Status' => $data->peso_Status,
                    'Gender' => $data->employee->gender == 1 ? 'MALE' : ($data->employee->gender == 2 ? 'FEMALE' : 'UNKNOWN'),
                    'Birth Date' => $data->employee->birthdate->format('Y-m-d'),
                    'Address' => $data->employee->address . " " . $data->employee->barangay->barangay_Name,

                ]);
            }

            toastr()->success('Data Exported');
            return Response::streamDownload(function () use ($writer) {
                $writer->close();
            }, $fileName, ['Content-Type' => 'text/csv']);
        }

        return toastr()->warning('No data in the table to be exported.');

    }

    public function getApplicants($id)
    {
        return Job_Applicants::with(['employee'])
            ->join('employee', 'job_applicants.employee_id', '=', 'employee.employee_id')
            ->where('job_applicants.job_id', $id)
            ->where(function ($query) {
                $query->where('employee.fname', 'like', '%' . $this->search . '%')
                    ->orWhere('employee.mname', 'like', '%' . $this->search . '%')
                    ->orWhere('employee.lname', 'like', '%' . $this->search . '%');
            });
    }

    public function render()
    {
        $user = Auth::user();

        $jobpost = Job_Posting::with(['company'])
            ->withCount('hiredApplicants')
            ->findOrFail($this->id);

        if ($user->peso_accounts->peso_id != $jobpost->peso_id) {
            return redirect()->back();
        }

        if ($jobpost) {
            $jobpost->slotsLeft = $jobpost->job_Slots - $jobpost->hired_applicants_count;
        } else {
            toastr()->error('Job posting cant be found.');
            return redirect()->route('admin-joblist');

        }

        // Fetch job applicants
        $jobApplicants = $this->getApplicants($jobpost->job_id)
            ->paginate(10);

        return view('livewire.admin.job-posting.applicants.job-post-applicants', compact('jobpost', 'jobApplicants'));
    }

}
