<?php

namespace App\Livewire\Admin\Super;

use App\Models\Employee;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Dashboard extends Component
{


    public function render()
    {

        // Fetch totals and recent counts
        $jobPostings = Job_Posting::selectRaw('
            COUNT(*) AS total_job_postings,
            SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) AS recent_job_postings
        ', [Carbon::now()->subHours(24)])
            ->first();

        $employees = Employee::selectRaw('
            COUNT(*) AS total_job_seekers,
            SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) AS recent_job_seekers,
            SUM(CASE WHEN empstatus = 1 THEN 1 ELSE 0 END) AS total_employed,
            SUM(CASE WHEN empstatus = 2 THEN 1 ELSE 0 END) AS total_unemployed
        ', [Carbon::now()->subHours(24)])
            ->first();

        $activeApplicants = Job_Applicants::selectRaw('
            COUNT(*) AS total_active_applicants,
            SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) AS recent_active_applicants
        ', [Carbon::now()->subHours(24)])
            ->whereNotIn('applicant_Status', ['REJECTED', 'ACCEPTED', 'CANCELLED'])
            ->first();

        // Generate chart models

        return view('livewire.admin.super.dashboard', [
            'totalJobPostings' => $jobPostings->total_job_postings,
            'recentJobPostings' => $jobPostings->recent_job_postings,
            'totalJobSeekers' => $employees->total_job_seekers,
            'recentJobSeekers' => $employees->recent_job_seekers,
            'totalEmployed' => $employees->total_employed,
            'totalUnemployed' => $employees->total_unemployed,
            'totalActiveApplicants' => $activeApplicants->total_active_applicants,
            'recentActiveApplicants' => $activeApplicants->recent_active_applicants,
        ]);
    }

}
