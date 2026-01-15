<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Experimental_Features;
use App\Models\Job_Applicants;
use App\Models\PESO;
use App\Models\Province;
use App\Models\Work_Exp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelWriter;

class JobseekersList extends Component
{

    use WithPagination;
    use WithoutUrlPagination;
    public $municipalityID, $provinceID;

    public $searchJobseekers, $searchCompany;
    public $startYear, $currentYear;

    public $Gender, $Age = [], $EmpStatus, $jobseekerfilter, $civilStatus, $educationAttainment, $selectedMonths = [],
    $selectedYear, $OFWFilter, $fourPFilter, $municipalityFilter;
    public $mountGender, $mountAge = [], $mountEmpStatus, $mountJobseekerfilter, $mountCivilStatus, $mountEducationAttainment, $mountSelectedMonths = [],
    $mountSelectedYear, $mountOFWFilter, $mountFourPFilter, $mountMunicipalityFilter;

    public $companyMun, $companyProv, $munYear, $munMonths = [];
    public $mountCompanyMun, $mountCompanyProv, $mountMunYear, $mountMunMonths = [];

    public $filterOption;

    #[On('updateProv')]
    public function updateProv($id)
    {
        $this->provinceID = $id;
    }

    #[On('updateMun')]
    public function updateMun($id)
    {
        $this->municipalityID = $id;
    }

    public function updatedsearchJobseekers()
    {
        $this->resetPage('jobseeker');
    }
    public function updatedsearchCompany()
    {
        $this->resetPage('company');
    }

    public function mount()
    {
        $this->startYear = 2024;
        $this->currentYear = date('Y');

    }

    public function exportExcel($type)
    {
        if ($type == 'jobseekers') {

            $jobseekers = null;
            if ($this->municipalityID) {
                $jobseekers = $this->getJobseekers($this->municipalityID)->get();
            } else if ($this->provinceID) {
                $jobseekers = $this->getJobseekers(null, $this->provinceID)->get();

            }

            if (!$jobseekers->isEmpty()) {

                $fileName = 'jobseekers-reports-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

                $writer = SimpleExcelWriter::streamDownload($fileName);

                foreach ($jobseekers as $data) {
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

        } elseif ($type == 'employers') {
            $employers = null;

            if ($this->municipalityID) {
                $employers = $this->getEmployers($this->municipalityID)->get();
            } elseif ($this->provinceID) {
                $employers = $this->getEmployers(null, $this->provinceID)->get();
            }

            if (!$employers->isEmpty()) {

                $fileName = 'employers-reports-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

                $writer = SimpleExcelWriter::streamDownload($fileName);

                foreach ($employers as $data) {
                    $writer->addRow([
                        'Company' => $data->business_Name,
                        'Contact Person' => $data->contact_Person,
                        'Contact Number' => $data->company_Pnum,
                        'Job Postings' => $data->total_job_postings,
                        'Hired Applicants' => $data->hired_applicants,
                    ]);
                }

                return Response::streamDownload(function () use ($writer) {
                    $writer->close();
                }, $fileName, ['Content-Type' => 'text/csv']);
            }

            return toastr()->warning('No data in the table to be exported.');
        }
    }

    public function exportPdf($type)
    {
        $pesoInformation = [];

        if ($this->municipalityID) {
            $pesoBranch = PESO::where('municipality_id', $this->municipalityID)->first();
            $pesoInformation = [
                'pesoMunicipality' => $pesoBranch->municipality->municipality_Name,
                'pesoProvince' => $pesoBranch->municipality->province->province_Name,
                'pesoEmail' => $pesoBranch->peso_Email,
                'pesoPhone' => $pesoBranch->peso_Phone,
                'pesoTel' => $pesoBranch->peso_Tel,
                'pesoFax' => $pesoBranch->peso_Fax,
            ];
        } else if ($this->provinceID) {
            $province = Province::findOrFail($this->provinceID);
            $pesoInformation = [
                'pesoMunicipality' => '',
                'pesoProvince' => $province->province_Name,
                'pesoEmail' => '',
                'pesoPhone' => '',
                'pesoTel' => '',
                'pesoFax' => '',
            ];
        }

        if ($type == 'jobseekers') {

            $jobseekers = null;
            if ($this->municipalityID) {
                $jobseekers = $this->getJobseekers($this->municipalityID)->get();
            } else if ($this->provinceID) {
                $jobseekers = $this->getJobseekers(null, $this->provinceID)->get();
            }

            if (!$jobseekers->isEmpty()) {
                $fileName = 'jobseeker_report_' . now()->format('Y_m_d_H_i_s') . '.pdf';

                $jobseekers = $jobseekers->map(function ($jobseeker) {
                    $maxEduLevel = $jobseeker->education->max('edu_Level');
                    $educationAttainment = $this->mapEducationAttainment($maxEduLevel);
                    $totalWorkExperience = Work_Exp::getTotalExperience($jobseeker->employee_id);

                    return [
                        'employee_id' => $jobseeker->employee_id,
                        'name' => $jobseeker->fname . ' ' . $jobseeker->mname . ' ' . $jobseeker->lname,
                        'gender' => $jobseeker->gender,
                        'empStat' => $jobseeker->empstatus,
                        'eduAttainment' => $educationAttainment,
                        'workExp' => $totalWorkExperience . ' Months',
                        'birthDate' => $jobseeker->birthdate->format('Y-m-d'),
                        'barangay' => $jobseeker->barangay->barangay_Name,
                        'province' => $jobseeker->barangay->municipality->province->province_Name,
                    ];
                });

                // dd($sendpeso);

                // Combine both datasets
                $data = [
                    'employees' => $jobseekers,
                    'peso' => $pesoInformation,
                    'fileName' => $fileName,
                ];

                $encryptedData = Crypt::encryptString(json_encode($data));

                return redirect()->route('export.municipality.jobseeker', ['data' => $encryptedData]);
            } else {
                return toastr()->warning('No data in the table to be exported.');
            }
        } elseif ($type == 'employers') {
            $employers = null;

            if ($this->municipalityID) {
                $employers = $this->getEmployers($this->municipalityID)->get();
            } elseif ($this->provinceID) {
                $employers = $this->getEmployers(null, $this->provinceID)->get();
            }

            if (!$employers->isEmpty()) {

                $fileName = 'employer_report_' . now()->format('Y_m_d_H_i_s') . '.pdf';

                $employers = $employers->map(function ($emp) {
                    return [
                        'companyName' => $emp->business_Name,
                        'contactPerson' => $emp->contact_Person,
                        'contactNumber' => $emp->company_Pnum,
                        'jobPostings' => $emp->total_job_postings,
                        'hiredApplicants' => $emp->hired_applicants,
                    ];
                });

                // dd($sendpeso);

                // Combine both datasets
                $data = [
                    'employer' => $employers,
                    'peso' => $pesoInformation,
                    'fileName' => $fileName,
                ];

                $encryptedData = Crypt::encryptString(json_encode($data));

                return redirect()->route('export.employer', ['data' => $encryptedData]);
            } else {
                return toastr()->warning('No data in the table to be exported.');

            }
        }
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

    public function resetFilter()
    {
        $this->reset('mountGender', 'mountAge', 'mountEmpStatus', 'mountJobseekerfilter', 'mountCivilStatus', 'mountEducationAttainment', 'mountSelectedMonths', 'mountSelectedYear', 'mountOFWFilter', 'mountFourPFilter', 'mountMunicipalityFilter',
            'Gender', 'Age', 'EmpStatus', 'jobseekerfilter', 'civilStatus', 'educationAttainment', 'selectedMonths', 'selectedYear', 'OFWFilter', 'fourPFilter', 'municipalityFilter');
        $this->resetPage('jobseeker');

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

        $this->selectedMonths = $this->mountSelectedMonths;
        $this->selectedYear = $this->mountSelectedYear;

        $this->municipalityFilter = $this->mountMunicipalityFilter;

        $this->resetPage('jobseeker');

        $this->dispatch('close-modal', 'filter-jobseekers-modal');
    }

    public function mountMunFilter()
    {
        $this->companyMun = $this->mountCompanyMun;
        $this->munYear = $this->mountMunYear;
        $this->munMonths = $this->mountMunMonths;

        $this->companyProv = $this->mountCompanyProv;

        $this->resetPage('company');

        $this->dispatch('close-modal', 'filter-employers-modal');

    }
    public function resetMunFilter()
    {
        $this->reset('companyMun', 'munYear', 'munMonths', 'mountCompanyMun', 'mountMunYear', 'companyProv', 'mountCompanyProv');
        $this->resetPage('company');
    }

    private function getJobseekers($municipalityId = null, $provinceId = null)
    {
        $employee = Employee::whereHas('job_applicants', function ($query) use ($municipalityId, $provinceId) {
            // Apply year filter if provided
            if (!empty($this->selectedYear)) {
                $query->whereYear('created_at', $this->selectedYear);
            }

            // Apply month filter if provided
            if (!empty($this->selectedMonths) && is_array($this->selectedMonths)) {
                $query->whereIn(DB::raw('MONTH(created_at)'), $this->selectedMonths);
            }

            // Apply municipality or province filtering logic
            $query->whereHas('job_posting', function ($query) use ($municipalityId, $provinceId) {
                $query->whereHas('peso', function ($query) use ($municipalityId, $provinceId) {
                    // Check if municipality ID is provided
                    if ($municipalityId) {
                        $query->where('municipality_id', $municipalityId);
                    } else {
                        // Otherwise, apply province filtering logic
                        $query->whereHas('municipality', function ($query) use ($municipalityId, $provinceId) {
                            $query->where('province_id', $provinceId);
                        });
                    }
                });
            });
        })
            ->withCount(['job_applicants as job_applications' => function ($query) {
                // Count job applications with the same filters
                if (!empty($this->selectedYear)) {
                    $query->whereYear('created_at', $this->selectedYear);
                }

                if (!empty($this->selectedMonths) && is_array($this->selectedMonths)) {
                    $query->whereIn(DB::raw('MONTH(created_at)'), $this->selectedMonths);
                }
            }])
            ->withCount('program_reg')
            ->where(function ($query) {
                $query->where('fname', 'like', '%' . $this->searchJobseekers . '%')
                    ->orWhere('mname', 'like', '%' . $this->searchJobseekers . '%')
                    ->orWhere('lname', 'like', '%' . $this->searchJobseekers . '%');
            });

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
                    // No additional filtering needed for 'all'
                    break;
            }
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

        if (isset($this->municipalityFilter)) {
            switch ($this->municipalityFilter) {
                case 1:
                    $employee->whereHas('barangay', function ($query) use ($municipalityId) {
                        $query->where('municipality_id', $municipalityId);
                    });
                    break;
                case 2:
                    $employee->whereDoesntHave('barangay', function ($query) use ($municipalityId) {
                        $query->where('municipality_id', $municipalityId);
                    });
                    break;
                default:
                    // No additional filtering needed for 'all'
                    break;
            }
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

    private function getEmployers($municipalityId = null, $provinceId = null)
    {
        $companiesQuery = Company::query();

        // Apply company municipality filter first
        $companiesQuery->where(function ($query) use ($municipalityId) {
            switch ($this->companyMun) {
                case 'within_municipality':
                    // Filter companies where the associated barangay's municipality_id matches the provided municipality
                    if ($municipalityId) {
                        $query->whereHas('barangay', function ($innerQuery) use ($municipalityId) {
                            $innerQuery->where('municipality_id', $municipalityId);
                        });
                    }
                    break;
                case 'outside_municipality':
                    // Filter companies where the associated barangay's municipality_id is different or null
                    if ($municipalityId) {
                        $query->whereHas('barangay', function ($innerQuery) use ($municipalityId) {
                            $innerQuery->where('municipality_id', '!=', $municipalityId)
                                ->orWhereNull('municipality_id');
                        });
                    }
                    break;
                case 'all':
                default:
                    // No additional filtering needed for 'all'
                    break;
            }
        });

        $companiesQuery->where(function ($query) use ($provinceId) {
            switch ($this->companyProv) {
                case 'within_prov':
                    // Filter companies where the associated barangay's municipality_id matches the provided municipality
                    if ($provinceId) {
                        $query->whereHas('barangay.municipality', function ($innerQuery) use ($provinceId) {
                            $innerQuery->where('province_id', $provinceId);
                        });
                    }
                    break;
                case 'outside_prov':
                    // Filter companies where the associated barangay's municipality_id is different or null
                    if ($provinceId) {
                        $query->whereHas('barangay.municipality', function ($innerQuery) use ($provinceId) {
                            $innerQuery->where('province_id', '!=', $provinceId)
                                ->orWhereNull('province_id');
                        });
                    }
                    break;
                case 'all':
                default:
                    // No additional filtering needed for 'all'
                    break;
            }
        });

        // Filter job postings based on the provided municipality or province
        $companiesQuery->whereHas('job_posting', function ($query) use ($municipalityId, $provinceId) {
            $query->whereHas('barangay', function ($innerQuery) use ($municipalityId, $provinceId) {
                // If a specific municipality ID is provided, filter by that municipality
                if ($municipalityId) {
                    $innerQuery->where('municipality_id', $municipalityId);
                } elseif ($provinceId) {
                    // If a province ID is provided, filter by all municipalities within the province
                    $innerQuery->whereHas('municipality', function ($query) use ($provinceId) {
                        $query->where('province_id', $provinceId);
                    });
                }
            });
        });

        // Additional filtering for job postings based on year and month
        $companiesQuery->whereHas('job_posting', function ($query) {
            // Apply year filter if provided
            if (!empty($this->munYear)) {
                $query->whereYear('created_at', $this->munYear);
            }

            // Apply month filter if provided
            if (!empty($this->munMonths) && is_array($this->munMonths)) {
                $query->whereIn(DB::raw('MONTH(created_at)'), $this->munMonths);
            }
        });

        // Count job postings in the municipality with date and month filters
        $companiesQuery->withCount(['job_posting as total_job_postings' => function ($query) use ($municipalityId) {
            $query->whereHas('barangay', function ($innerQuery) use ($municipalityId) {
                if ($municipalityId) {
                    $innerQuery->where('municipality_id', $municipalityId);
                }
            });

            if (!empty($this->munYear)) {
                $query->whereYear('created_at', $this->munYear);
            }

            if (!empty($this->munMonths) && is_array($this->munMonths)) {
                $query->whereIn(DB::raw('MONTH(created_at)'), $this->munMonths);
            }
        }]);

        // Apply search filter
        if (!empty($this->searchCompany)) {
            $companiesQuery->where(function ($query) {
                $query->where('business_Name', 'like', '%' . $this->searchCompany . '%')
                    ->orWhere('trade_Name', 'like', '%' . $this->searchCompany . '%');
            });
        }

        // Add subquery to count hired applicants
        $companiesQuery->addSelect([
            'hired_applicants' => Job_Applicants::selectRaw('COUNT(*)')
                ->join('job_posting', 'job_posting.job_id', '=', 'job_applicants.job_id')
                ->whereIn('applicant_status', ['HIRED', 'COMPLETED'])
                ->whereColumn('job_posting.company_id', 'company.company_id'),
        ]);

        // Debug the query
        // dd($companiesQuery->toSql(), $companiesQuery->getBindings());

        // Return paginated results
        return $companiesQuery;
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

        $jobseekers = null;
        $employers = null;
        if ($this->municipalityID) {
            $jobseekers = $this->getJobseekers($this->municipalityID)->paginate(10, ['*'], 'jobseeker');
            $employers = $this->getEmployers($this->municipalityID)->paginate(10, ['*'], 'company');
        } elseif ($this->provinceID) {
            $jobseekers = $this->getJobseekers(null, $this->provinceID)->paginate(10, ['*'], 'jobseeker');
            $employers = $this->getEmployers(null, $this->provinceID)->paginate(10, ['*'], 'company');
        }
        $crossJob = $this->getFeature();

        return view('livewire.admin.reports.municipality-partials.jobseekers-list', compact('jobseekers', 'employers', 'crossJob'));
    }
}
