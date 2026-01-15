<?php

namespace App\Livewire\Admin\Accounts\Employer;

use App\Models\Partnerships;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelWriter;

#[Layout('layouts.admin')]
class EmployerManagement extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $searchEmployers;

    public $companyType, $empType, $empDesc, $jobPosting, $location;

    public $mountCompanyType, $mountEmpType, $mountEmpDesc, $mountJobPosting, $mountLocation;

    public $sortName = 'ASC';

    public function updatedsearchEmployers()
    {
        $this->resetPage(); // Reset pagination for eligibility search
    }

    public function updateSort($value)
    {
        $this->sortName = $value;
        $this->resetPage(); // Reset pagination for eligibility search

    }

    public function mountFilter()
    {
        $this->companyType = $this->mountCompanyType;
        $this->empType = $this->mountEmpType;
        $this->empDesc = $this->mountEmpDesc;
        $this->jobPosting = $this->mountJobPosting;
        $this->location = $this->mountLocation;

        $this->resetPage();

        $this->dispatch('close-modal', 'filter-employer-modal');
    }

    public function resetFilter()
    {
        $this->reset('mountCompanyType', 'mountEmpType', 'mountEmpDesc', 'mountJobPosting', 'mountLocation',
            'companyType', 'empType', 'empDesc', 'jobPosting', 'location');
        $this->resetPage();

    }

    public function getEmployers()
    {
        $user = Auth::user();
        $municipalityId = $user->peso_accounts->peso->municipality_id; // Store this outside the closure

        // Ensure searchEmployers has a default value if not set
        $searchEmployers = $this->searchEmployers ?? '';

        $query = Partnerships::where('peso_id', $user->peso_accounts->peso_id)
            ->where('partnership_Status', 'APPROVED')
            ->whereHas('company', function ($query) use ($municipalityId, $searchEmployers) {
                // Apply the search filter
                $query->where(function ($q) use ($searchEmployers) {
                    $q->where('trade_Name', 'like', '%' . $searchEmployers . '%')
                        ->orWhere('business_Name', 'like', '%' . $searchEmployers . '%');
                });
                // $query->orderBy('business_Name', $this->sortName);

                // Apply Company Type filter
                if ($this->companyType) {
                    $query->where('company_Type', $this->companyType);
                }

                // Apply Employment Type filter
                if ($this->empType) {
                    $query->where('employer_Type', $this->empType);
                }

                // Apply Employment Type Description filter
                if ($this->empDesc) {
                    $query->where('employer_Type_Desc', $this->empDesc);
                }

                // Apply Job Posting filter
                // Apply Job Posting filter
                if ($this->jobPosting === 'with_posting') {
                    $query->whereHas('job_posting', function ($q) {
                        $q->whereIn('job_Status', ['PENDING', 'ACTIVE', 'CLOSED']);
                    });
                } elseif ($this->jobPosting === 'without_posting') {
                    $query->whereDoesntHave('job_posting', function ($q) {
                        $q->whereIn('job_Status', ['PENDING', 'ACTIVE', 'CLOSED']);
                    });
                }

                // Apply Location filter
                switch ($this->location) {
                    case 'within':
                        $query->whereHas('barangay', function ($q) use ($municipalityId) {
                            $q->where('municipality_id', $municipalityId);
                        });
                        break;
                    case 'outside':
                        $query->whereHas('barangay', function ($q) use ($municipalityId) {
                            $q->where('municipality_id', '!=', $municipalityId);
                        });
                        break;
                }
            });
        // dd($query->toRawSql());
        return $query;
    }

    public function exportData()
    {
        $employers = $this->getEmployers()->get();

        if (!$employers->isEmpty()) {

            $fileName = 'employers-reports-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

            $writer = SimpleExcelWriter::streamDownload($fileName);

            foreach ($employers as $data) {
                $writer->addRow([
                    'Company' => $data->company->business_Name,
                    'Contact Person' => $data->company->contact_Person,
                    'Contact Number' => $data->company->company_Pnum,
                    'Company Type' => $data->company->company_Type == 1 ? 'MAIN' : ($data->company->company_Type == 2 ? 'BRANCH' : 'UNKNOWN'),
                    'Employment Type' => $data->company->employer_Type == 1 ? 'PUBLIC' : ($data->company->employer_Type == 2 ? 'PRIVATE' : 'UNKNOWN'),

                ]);
            }

            return Response::streamDownload(function () use ($writer) {
                $writer->close();
            }, $fileName, ['Content-Type' => 'text/csv']);
        }

        return toastr()->warning('No data in the table to be exported.');

    }
    public function render()
    {

        $partnersData = $this->getEmployers()->paginate(10);

        return view('livewire.admin.accounts.employer.employer-management', compact('partnersData'));
    }
}
