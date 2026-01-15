<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Barangay;
use App\Models\Employee;
use App\Models\Job_Applicants;
use App\Models\Programs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelWriter;

#[Layout('layouts.admin')]
class BarangayReports extends Component
{
    use WithPagination;
    use WithoutUrlPagination;

    public $searchBar;
    public $selectedBar, $barTitle;

    public function mount()
    {
        $user = Auth::user();
        $this->initializeBarangay($user);

    }

   
    private function generateCsvContent($employees, $headers)
    {
        $output = fopen('php://temp', 'r+'); // Use a temporary stream for CSV content

        // Add headers to the CSV
        fputcsv($output, $headers);

        foreach ($employees as $employee) {
            fputcsv($output, [
                $employee->fname,
                $employee->mname,
                $employee->lname,
                $employee->gender,
                $employee->birthdate->format('Y-m-d'),
                $employee->empstatus,
                $employee->active_applications_count,
                $employee->program_reg_count,
            ]);
        }

        rewind($output); // Rewind to the beginning of the stream
        $csvContent = stream_get_contents($output); // Get the content of the stream
        fclose($output); // Close the stream

        return $csvContent;
    }

 

    private function initializeBarangay($user)
    {
        $pesoMunicipalityId = optional($user->peso_accounts->peso)->municipality_id;

        $barangay = Barangay::with('municipality')
            ->where('municipality_id', $pesoMunicipalityId)
            ->orderBy('barangay_Name', 'ASC')
            ->first();

        $this->barSelect($barangay?->barangay_id);
    }

    public function barSelect($id)
    {
        $barangay = Barangay::findOrFail($id);

        $this->selectedBar = $id;
        $this->barTitle = $barangay->barangay_Name;
        $this->dispatch('updateBar', $id);
    }
    private function getBarangays($municipalityId)
    {
        $barangay = Barangay::with('municipality')
            ->where('municipality_id', $municipalityId)
            ->where('barangay_Name', 'like', '%' . $this->searchBar . '%')
            ->orderBy('barangay_Name', 'ASC')
            ->get();

        return compact('barangay');
    }

    private function getStatistics()
    {
        $filters = ['barangay_id' => $this->selectedBar];

        return [
            'totalJobSeekers' => $this->getEmployeeCount($filters),
            'recentJobSeekers' => $this->getRecentEmployeeCount($filters),
            'totalEmployed' => $this->getEmployeeCount(array_merge($filters, ['empstatus' => 1])),
            'totalUnemployed' => $this->getEmployeeCount(array_merge($filters, ['empstatus' => 2])),
            'totalActiveApplicants' => $this->getActiveApplicantCount($filters),
            'recentActiveApplicants' => $this->getRecentActiveApplicantCount($filters),
        ];
    }


    private function getEmployeeCount(array $filters)
    {
        return Employee::where(function ($query) use ($filters) {
            // Apply the barangay filter
            if (isset($filters['barangay_id'])) {
                $query->whereHas('barangay', function ($query) use ($filters) {
                    $query->where('barangay_id', $filters['barangay_id']);
                });
            }

            // Apply the empstatus filter (and any other filters passed in)
            if (isset($filters['empstatus'])) {
                $query->where('empstatus', $filters['empstatus']);
            }

            // Add more filters as needed
            // ...
        })->count();
    }
    private function getRecentEmployeeCount(array $filters)
    {
        return Employee::whereHas('barangay', function ($query) use ($filters) {
            $query->where('barangay_id', $filters['barangay_id']);
        })
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->count();
    }

    private function getActiveApplicantCount(array $filters)
    {
        return Job_Applicants::whereNotIn('applicant_Status', ['REJECTED', 'COMPLETED', 'CANCELLED'])
            ->whereHas('employee.barangay', function ($query) use ($filters) {
                $query->where('barangay_id', $filters['barangay_id']);
            })
            ->count();
    }

    private function getRecentActiveApplicantCount(array $filters)
    {
        return Job_Applicants::whereNotIn('applicant_Status', ['REJECTED', 'COMPLETED', 'CANCELLED'])
            ->whereHas('job_posting.barangay', function ($query) use ($filters) {
                $query->where('barangay_id', $filters['barangay_id']);
            })
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->count();
    }

  

    public function render()
    {
        $user = Auth::user();

        $pesoMunicipalityId = optional($user->peso_accounts->peso)->municipality_id;

        $barangays = $this->getBarangays($pesoMunicipalityId);
        $stats = $this->getStatistics();

        return view('livewire.admin.reports.barangay-reports', array_merge($barangays, $stats));
    }

}
