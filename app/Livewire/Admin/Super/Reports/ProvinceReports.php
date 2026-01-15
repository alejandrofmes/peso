<?php

namespace App\Livewire\Admin\Super\Reports;

use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use App\Models\Municipality;
use App\Models\Province;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class ProvinceReports extends Component
{

    public $searchProv;
    public $selectedProv, $provTitle;
    public $selectedAnalytics, $analyticsValue;

    public function mount()
    {
        $this->selectedAnalytics = 1;
        $this->analyticsValue = 'Jobseekers';
        $firstMun = Municipality::first();
        $this->munSelect($firstMun->municipality_id);

    }

    public function updateAnalytics($id)
    {
        $this->selectedAnalytics = $id;

        if ($id == 1) {
            $this->analyticsValue = 'Jobseekers';

        } elseif ($id == 2) {
            // dd($this->selectedAnalytics);
            $this->analyticsValue = 'Trends';

        } elseif ($id == 3) {
            $this->analyticsValue = 'Top';
        }
    }

    public function munSelect($id)
    {
        $province = Province::findOrFail($id);

        $this->selectedProv = $id;
        $this->provTitle = $province->province_Name;
        $this->dispatch('updateProv', $id);
    }

    public function getTotalJobSlots($provinceId)
    {
        // Get total number of job slots for the given municipality
        $totalJobSlots = Job_Posting::whereHas('peso.municipality.province', function ($query) use ($provinceId) {
            $query->where('province_id', $provinceId);
        })
            ->where('job_Status', 'ACTIVE')
            ->sum('job_Slots'); // Sum up all job slots for the municipality

        // Get the total number of hired applicants for the given municipality
        $hiredApplicantsCount = Job_Applicants::whereIn('applicant_status', ['HIRED', 'COMPLETED'])
            ->whereHas('job_posting.peso.municipality.province', function ($query) use ($provinceId) {
                $query->where('province_id', $provinceId);
            })
            ->count();

        // Calculate the remaining slots
        $remainingSlots = max($totalJobSlots - $hiredApplicantsCount, 0);

        return [
            'total_job_slots' => $totalJobSlots,
            'remaining_slots' => $remainingSlots,
        ];
    }

    public function getJobPosting($id)
    {
        return Job_Posting::whereHas('peso.municipality.province', function ($query) use ($id) {
            $query->where('province_id', $id);
        })
            ->where('job_Status', 'ACTIVE')->count();

    }

    public function getRecentJobPosting($id)
    {
        return Job_Posting::whereHas('peso.municipality.province', function ($query) use ($id) {
            $query->where('province_id', $id);
        })
            ->where('job_Status', 'ACTIVE')
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->count();
    }
    private function getActiveApplicantCount($provinceId)
    {
        return Job_Applicants::whereNotIn('applicant_Status', ['REJECTED', 'COMPLETED', 'CANCELLED'])
            ->whereHas('employee.barangay.municipality.province', function ($query) use ($provinceId) {
                $query->where('province_id', $provinceId);
            })
            ->count();
    }

    private function getRecentActiveApplicantCount($provinceId)
    {
        return Job_Applicants::whereNotIn('applicant_Status', ['REJECTED', 'COMPLETED', 'CANCELLED'])
            ->whereHas('job_posting.barangay.municipality.province', function ($query) use ($provinceId) {
                $query->where('province_id', $provinceId);
            })
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->count();
    }

    private function getProvince()
    {
        // Fetch provinces that have municipalities with PESO
        $provinces = Province::whereHas('municipality', function ($query) {
            $query->whereHas('peso'); // Ensure municipality has an associated PESO
        })
            ->where('province_Name', 'like', '%' . $this->searchProv . '%') // Search by province_Name
            ->orderBy('province_Name', 'ASC')
            ->get();

        return $provinces;
    }

    public function render()
    {

        $activeJobPosting = $this->getJobPosting($this->selectedProv);
        $recentJobPosting = $this->getRecentJobPosting($this->selectedProv);

        $jobSlotsData = $this->getTotalJobSlots($this->selectedProv);
        $totalJobSlots = $jobSlotsData['total_job_slots'];
        $remainingSlots = $jobSlotsData['remaining_slots'];

        $activeApplicants = $this->getActiveApplicantCount($this->selectedProv);
        $recentApplicants = $this->getRecentActiveApplicantCount($this->selectedProv);

        $province = $this->getProvince();

        // dd($municipalities);

        return view('livewire.admin.super.reports.province-reports',
            compact('activeJobPosting', 'recentJobPosting',
                'totalJobSlots', 'remainingSlots', 'activeApplicants', 'recentApplicants'
                , 'province'));
    }
}
