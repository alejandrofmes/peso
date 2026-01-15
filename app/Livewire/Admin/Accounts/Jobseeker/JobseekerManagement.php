<?php

namespace App\Livewire\Admin\Accounts\Jobseeker;

use App\Models\Employee;
use App\Models\Work_Exp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelWriter;

#[Layout('layouts.admin')]
class JobseekerManagement extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $paginate = 10;
    public $searchUsers;

    public $Gender, $Age = [], $EmpStatus, $jobseekerfilter, $civilStatus, $educationAttainment, $OFWFilter, $fourPFilter;
    public $mountGender, $mountAge = [], $mountEmpStatus, $mountJobseekerfilter, $mountCivilStatus, $mountEducationAttainment, $mountOFWFilter, $mountFourPFilter;

    public $userFilter = 'ALL';

    public $sortName = 'ASC';
    public function updatedsearchUsers()
    {
        $this->resetPage(); // Reset pagination for eligibility search
    }

    public function updateSort($value)
    {
        $this->sortName = $value;
    }

    public function mountFilter()
    {
        $this->Gender = $this->mountGender;
        $this->Age = $this->mountAge;
        $this->EmpStatus = $this->mountEmpStatus;
        $this->jobseekerfilter = $this->mountJobseekerfilter;
        $this->civilStatus = $this->mountCivilStatus;
        $this->educationAttainment = $this->mountEducationAttainment;
        $this->OFWFilter = $this->mountOFWFilter;
        $this->fourPFilter = $this->mountFourPFilter;

        $this->resetPage();

        $this->dispatch('close-modal', 'filter-jobseekers-modal');
    }

    public function resetFilter()
    {
        $this->reset('mountGender', 'mountAge', 'mountEmpStatus', 'mountJobseekerfilter', 'mountCivilStatus', 'mountEducationAttainment', 'mountOFWFilter', 'mountFourPFilter',
            'Gender', 'Age', 'EmpStatus', 'jobseekerfilter', 'civilStatus', 'educationAttainment', 'OFWFilter', 'fourPFilter');
        $this->resetPage();

    }

    private function getJobseekers($id)
    {
        $employee = Employee::whereHas('barangay', function ($query) use ($id) {
            $query->where('municipality_id', $id);
        })
        // ->whereHas('job_applicants')
            ->withCount('job_applicants as job_applications')
            ->withCount('program_reg')
            ->where(function ($query) {
                $query->where('fname', 'like', '%' . $this->searchUsers . '%')
                    ->orWhere('mname', 'like', '%' . $this->searchUsers . '%')
                    ->orWhere('lname', 'like', '%' . $this->searchUsers . '%');
            });

        $employee->orderBy('lname', $this->sortName);
        // Filter by gender
        if ($this->Gender) {
            $employee->where('gender', $this->Gender);
        }

        // Filter by employment status
        if ($this->EmpStatus) {
            $employee->where('empstatus', $this->EmpStatus);
        }
        if ($this->OFWFilter) {
            $employee->where('ofw', $this->OFWFilter);
        }
        if ($this->fourPFilter) {
            $employee->where('fourp', $this->fourPFilter);
        }

        // Filter by age
        if ($this->Age) {
            $employee->where(function ($query) {
                $currentYear = Carbon::now()->year;
                foreach ($this->Age as $range) {
                    list($minAge, $maxAge) = explode('-', $range);
                    $minYear = $currentYear - $maxAge;
                    $maxYear = $currentYear - $minAge;
                    $query->orWhereBetween('birthdate', [$minYear . '-01-01', $maxYear . '-12-31']);
                }
            });
            $employee->orderByRaw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) ASC');
        }
        if (isset($this->civilStatus)) {
            $employee->where('civilstatus', $this->civilStatus);
        }

        // Filter for jobseekers based on job applications
        if (isset($this->jobseekerfilter)) {
            switch ($this->jobseekerfilter) {
                case 'with_applications':
                    $employee->whereHas('job_applicants');
                    break;
                case 'without_applications':
                    $employee->doesntHave('job_applicants');
                    break;
                case 'all':
                default:

                    break;
            }
        }
        if (!empty($this->educationAttainment)) {
            $employee->whereHas('education', function ($query) {
                $query->select(DB::raw('MAX(edu_Level) as max_edu_level'))
                    ->groupBy('employee_id')
                    ->havingRaw($this->getEducationAttainmentCondition());
            });
        }

        // Return paginated results
        return $employee;
    }

    private function getEducationAttainmentCondition()
    {
        switch ($this->educationAttainment) {
            case 'Elementary Graduate':
                return 'MAX(edu_Level) = 9';
            case 'High School Level':
                return 'MAX(edu_Level) BETWEEN 10 AND 15';
            case 'High School Graduate':
                return 'MAX(edu_Level) = 16';
            case 'College Level':
                return 'MAX(edu_Level) BETWEEN 19 AND 23';
            case 'College Graduate':
                return 'MAX(edu_Level) = 24';
            default:
                return '1=0'; // No valid condition, won't return results.
        }
    }

    public function exportData()
    {
        $user = Auth::user();

        $jobseekers = $this->getJobseekers($user->peso_accounts->peso->municipality_id)->get();

        if (!$jobseekers->isEmpty()) {

            $fileName = 'jobseekers-reports-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

            $writer = SimpleExcelWriter::streamDownload($fileName);

            foreach ($jobseekers as $data) {
                // Mapping for civil status
                $civilStatus = $data->civilstatus == 1 ? 'Single' :
                ($data->civilstatus == 2 ? 'Married' :
                    ($data->civilstatus == 3 ? 'Widowed' : 'Unknown'));

                // Fetch the highest educational attainment
                $maxEduLevel = $data->education->max('edu_Level');
                $educationAttainment = $this->mapEducationAttainment($maxEduLevel);

                $totalWorkExperience = Work_Exp::getTotalExperience($data->employee_id);

                $writer->addRow([
                    'First Name' => $data->fname,
                    'Middle Name' => $data->mname,
                    'Last Name' => $data->lname,
                    'Gender' => $data->gender == 1 ? 'MALE' : ($data->gender == 2 ? 'FEMALE' : 'UNKNOWN'),
                    'Date of Birth' => $data->birthdate->format('Y-m-d'),
                    'Civil Status' => $civilStatus,
                    'Employment Status' => $data->empstatus == 1 ? 'EMPLOYED' : ($data->empstatus == 2 ? 'UNEMPLOYED' : 'UNKNOWN'),
                    'Job Applications' => $data->job_applications,
                    'Program Registrations' => $data->program_reg_count,
                    'Educational Attainment' => $educationAttainment,
                    'Work Experience' => $totalWorkExperience . ' Months',

                ]);
            }

            return Response::streamDownload(function () use ($writer) {
                $writer->close();
            }, $fileName, ['Content-Type' => 'text/csv']);
        }

        return toastr()->warning('No data in the table to be exported.');

    }
    private function mapEducationAttainment($eduLevel)
    {
        switch ($eduLevel) {
            case 9:
                return 'Elementary Graduate';
            case ($eduLevel >= 10 && $eduLevel <= 15):
                return 'High School Level';
            case 16:
                return 'High School Graduate';
            case ($eduLevel >= 19 && $eduLevel <= 23):
                return 'College Level';
            case 24:
                return 'College Graduate';
            case ($eduLevel == 25):
                return 'Master Level';
            case ($eduLevel == 26):
                return 'Master Graduate';
            default:
                return 'Lower than Elementary Graduate';
        }
    }

    public function render()
    {

        $user = Auth::user();

        $jobseeker = $this->getJobseekers($user->peso_accounts->peso->municipality_id)->paginate($this->paginate);

        return view('livewire.admin.accounts.jobseeker.jobseeker-management', compact('jobseeker'));
    }
}
