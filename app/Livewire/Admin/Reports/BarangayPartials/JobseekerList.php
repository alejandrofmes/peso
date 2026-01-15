<?php

namespace App\Livewire\Admin\Reports\BarangayPartials;

use App\Models\Barangay;
use App\Models\Employee;
use App\Models\Experimental_Features;
use App\Models\PESO;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelWriter;

class JobseekerList extends Component
{

    use WithPagination;
    use WithoutUrlPagination;

    public $barangayID;

    public $currentYear;
    public $startYear;

    public $searchJobseekers;

    // MOUNT
    public $mountGender, $mountAge = [], $mountEmpStatus, $mountCivilStatus, $mountEducationAttainment, $mountOFWFilter, $mountFourPFilter;

    // REAL FILTER VALUES
    public $Gender, $Age = [], $EmpStatus, $civilStatus, $educationAttainment, $OFWFilter, $fourPFilter;

    public $mountSelectedMonths = [];

    public $selectedMonths = [];
    public $selectedYear;

    public function updatedsearchJobseekers()
    {
        $this->resetPage();
    }

    public function changeYear($year)
    {
        $this->selectedYear = $year;
    }

    public function changeMonth()
    {
        $this->mountSelectedMonths = $this->selectedMonths;
    }

    public function resetFilter()
    {
        $this->reset(
            'mountGender',
            'mountAge',
            'mountEmpStatus',
            'mountCivilStatus',
            'mountEducationAttainment',
            'mountOFWFilter',
            'mountFourPFilter',
            'Gender',
            'Age',
            'EmpStatus',
            'civilStatus',
            'educationAttainment',
            'OFWFilter',
            'fourPFilter'
        );
        $this->resetPage();
    }

    #[On('updateBar')]
    public function updateBar($id)
    {
        $this->barangayID = $id;
    }

    public function mount()
    {

        $this->currentYear = date('Y');
        $this->startYear = 2024;
        $this->selectedYear = $this->startYear;
    }

    public function mountFilter()
    {
        $this->Gender = $this->mountGender;
        $this->Age = $this->mountAge;
        $this->EmpStatus = $this->mountEmpStatus;
        $this->civilStatus = $this->mountCivilStatus;
        $this->educationAttainment = $this->mountEducationAttainment;
        $this->OFWFilter = $this->mountOFWFilter;
        $this->fourPFilter = $this->mountFourPFilter;

        $this->dispatch('close-modal', 'filter-jobseekers-modal');
        $this->resetPage();
    }

    private function getJobseekers()
    {

        $employee = Employee::where('barangay_id', $this->barangayID)
            ->withCount(['activeApplications', 'program_reg'])
            ->where(function ($query) {
                $query->where('fname', 'like', '%' . $this->searchJobseekers . '%')
                    ->orWhere('mname', 'like', '%' . $this->searchJobseekers . '%')
                    ->orWhere('lname', 'like', '%' . $this->searchJobseekers . '%');
            });

        if ($this->Gender) {
            $employee = $employee->where('gender', $this->Gender);
        }
        if ($this->EmpStatus) {
            $employee = $employee->where('empstatus', $this->EmpStatus);
        }
        if ($this->OFWFilter) {
            $employee->where('ofw', $this->OFWFilter);
        }
        if ($this->fourPFilter) {
            $employee->where('fourp', $this->fourPFilter);
        }
        if ($this->Age) {
            $employee = $employee->where(function ($query) {
                $currentYear = Carbon::now()->year;
                foreach ($this->Age as $range) {
                    list($minAge, $maxAge) = explode('-', $range);
                    $minYear = $currentYear - $maxAge;
                    $maxYear = $currentYear - $minAge;
                    $query->orWhereBetween('birthdate', [$minYear . '-01-01', $maxYear . '-12-31']);
                }
            });
            $employee = $employee->orderByRaw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) ASC');
        }

        if ($this->civilStatus) {
            $employee->where('civilstatus', $this->civilStatus);
        }
        if (!empty($this->educationAttainment)) {
            $employee->whereHas('education', function ($query) {
                $query->select(DB::raw('MAX(edu_Level) as max_edu_level'))
                    ->groupBy('employee_id')
                    ->havingRaw($this->getEducationAttainmentCondition());
            });
        }

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

    public function exportExcel()
    {
        $employees = $this->getJobseekers()->get();
        if (!$employees->isEmpty()) {

            $fileName = $this->barangayID . '-jobseekers-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

            $writer = SimpleExcelWriter::streamDownload($fileName);

            foreach ($employees as $employee) {
                $writer->addRow([
                    'First Name' => $employee->fname,
                    'Middle Name' => $employee->mname,
                    'Last Name' => $employee->lname,
                    'Gender' => $employee->gender == 1 ? 'MALE' : ($employee->gender == 2 ? 'FEMALE' : 'UNKNOWN'),
                    'Date of Birth' => $employee->birthdate->format('Y-m-d'),
                    'Employment Status' => $employee->empstatus == 1 ? 'EMPLOYED' : ($employee->empstatus == 2 ? 'UNEMPLOYED' : 'UNKNOWN'),
                    'Active Applications' => $employee->active_applications_count,
                    'Program Registrations' => $employee->program_reg_count,
                ]);
            }

            return Response::streamDownload(function () use ($writer) {
                $writer->close();
            }, $fileName, ['Content-Type' => 'text/csv']);
        }

        return toastr()->warning('No data in the table to be exported.');
    }

    public function exportPdf()
    {
        $jobs = $this->getJobseekers()->withCount(['activeApplications', 'program_reg'])->get();

        if ($jobs->isEmpty()) {
            return toastr()->warning('No data in the table to be exported.');
        } else {
            $fileName = 'jobseeker_report_' . now()->format('Y_m_d_H_i_s') . '.pdf';

            $barangay = Barangay::findOrFail($this->barangayID);
            $pesoBranch = PESO::where('municipality_id', $barangay->municipality_id)->first();

            $employees = $jobs->map(function ($data) {
                return [
                    'employee_id' => $data->employee_id,
                    'name' => $data->fname . ' ' . $data->mname . ' ' . $data->lname,
                    'gender' => $data->gender,
                    'empStat' => $data->empstatus,
                    'activeApplicationsCount' => $data->active_applications_count,
                    'programRegCount' => $data->program_reg_count,
                    'barangay' => $data->barangay->barangay_Name,
                    'province' => $data->barangay->municipality->province->province_Name,

                ];
            });

            $sendpeso = [
                'pesoMunicipality' => $pesoBranch->municipality->municipality_Name,
                'pesoProvince' => $pesoBranch->municipality->province->province_Name,
                'pesoEmail' => $pesoBranch->peso_Email,
                'pesoPhone' => $pesoBranch->peso_Phone,
                'pesoTel' => $pesoBranch->peso_Tel,
                'pesoFax' => $pesoBranch->peso_Fax,
                'barangay' => $barangay->barangay_Name,
            ];

            // Combine both datasets
            $data = [
                'employees' => $employees,
                'peso' => $sendpeso,
                'fileName' => $fileName,

            ];

            $encryptedData = Crypt::encryptString(json_encode($data));

            return redirect()->route('export.barangay.jobseeker', ['data' => $encryptedData]);
        }
    }

    public function getFeature()
    {
        $crossJobFeature = Experimental_Features::find(1);

        // Determine whether cross-municipality applications are enabled
        $isCrossJobEnabled = $crossJobFeature && $crossJobFeature->feature_Status === 'enabled';
        $crossJobFeature = Experimental_Features::find(1);

        // Determine whether cross-municipality applications are enabled
        return $crossJobFeature && $crossJobFeature->feature_Status === 'enabled';
    }
    public function render()
    {
        $barangayJobSeekers = $this->getJobseekers()->paginate(10);

        return view('livewire.admin.reports.barangay-partials.jobseeker-list', compact('barangayJobSeekers'));
    }
}
