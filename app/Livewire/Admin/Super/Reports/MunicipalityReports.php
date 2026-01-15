<?php

namespace App\Livewire\Admin\Super\Reports;

use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use App\Models\Municipality;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class MunicipalityReports extends Component
{

    public $searchMun;
    public $selectedMun, $munTitle;
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
        $municipality = Municipality::findOrFail($id);

        $this->selectedMun = $id;
        $this->munTitle = $municipality->municipality_Name . ', ' . $municipality->province->province_Name;
        $this->dispatch('updateMun', $id);
    }

    public function getTotalJobSlots($municipalityId)
    {
        // Get total number of job slots for the given municipality
        $totalJobSlots = Job_Posting::whereHas('peso.municipality', function ($query) use ($municipalityId) {
            $query->where('municipality_id', $municipalityId);
        })
            ->where('job_Status', 'ACTIVE')
            ->sum('job_Slots'); // Sum up all job slots for the municipality

        // Get the total number of hired applicants for the given municipality
        $hiredApplicantsCount = Job_Applicants::whereIn('applicant_status', ['HIRED', 'COMPLETED'])
            ->whereHas('job_posting.peso.municipality', function ($query) use ($municipalityId) {
                $query->where('municipality_id', $municipalityId);
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
        return Job_Posting::whereHas('peso.municipality', function ($query) use ($id) {
            $query->where('municipality_id', $id);
        })
            ->where('job_Status', 'ACTIVE')->count();

    }

    public function getRecentJobPosting($id)
    {
        return Job_Posting::whereHas('peso.municipality', function ($query) use ($id) {
            $query->where('municipality_id', $id);
        })
            ->where('job_Status', 'ACTIVE')
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->count();
    }
    private function getActiveApplicantCount($municipalityId)
    {
        return Job_Applicants::whereNotIn('applicant_Status', ['REJECTED', 'COMPLETED', 'CANCELLED'])
            ->whereHas('employee.barangay.municipality', function ($query) use ($municipalityId) {
                $query->where('municipality_id', $municipalityId);
            })
            ->count();
    }

    private function getRecentActiveApplicantCount($municipalityId)
    {
        return Job_Applicants::whereNotIn('applicant_Status', ['REJECTED', 'COMPLETED', 'CANCELLED'])
            ->whereHas('job_posting.barangay.municipality', function ($query) use ($municipalityId) {
                $query->where('municipality_id', $municipalityId);
            })
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->count();
    }

    private function getMunicipality()
    {
        $municipalities = Municipality::whereHas('PESO') // Ensure municipality has an associated PESO
            ->where('municipality_Name', 'like', '%' . $this->searchMun . '%') // Search by municipality_Name
            ->whereHas('province', function ($query) {
                $query->where('province_Name', 'like', '%' . $this->searchMun . '%');
            })
            ->orderBy('municipality_Name', 'ASC')
            ->get();
        return $municipalities;
    }

    public function render()
    {

        $activeJobPosting = $this->getJobPosting($this->selectedMun);
        $recentJobPosting = $this->getRecentJobPosting($this->selectedMun);

        $jobSlotsData = $this->getTotalJobSlots($this->selectedMun);
        $totalJobSlots = $jobSlotsData['total_job_slots'];
        $remainingSlots = $jobSlotsData['remaining_slots'];

        $activeApplicants = $this->getActiveApplicantCount($this->selectedMun);
        $recentApplicants = $this->getRecentActiveApplicantCount($this->selectedMun);

        $municipalities = $this->getMunicipality();

        // dd($municipalities);

        return view('livewire.admin.super.reports.municipality-reports',
            compact('activeJobPosting', 'recentJobPosting',
                'totalJobSlots', 'remainingSlots', 'activeApplicants', 'recentApplicants'
                , 'municipalities'));
    }
}
