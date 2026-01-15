<?php

namespace App\Livewire\Admin\Maintenance;

use App\Helpers\AuditFormatter;
use App\Models\Announcements;
use App\Models\Employee;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use App\Models\PESO_Accounts;
use App\Models\Programs;
use App\Models\Program_Reg;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;

#[Layout('layouts.admin')]
class MunicipalityAudits extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $filter = '';

    public function updateFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }
    public function render()
    {
        $user = Auth::user();
        $municipalityId = $user->peso_accounts->peso->municipality_id; // Set your municipality ID here

        // Get all User IDs associated with Employees in the specified municipality
        $employeeUserIds = Employee::whereHas('barangay', function ($query) use ($municipalityId) {
            $query->where('municipality_id', $municipalityId);
        })
            ->pluck('user_id');

        $pesoUserIds = PESO_Accounts::whereHas('peso', function ($query) use ($municipalityId) {
            $query->where('municipality_id', $municipalityId);
        })
            ->pluck('user_id');

        // Merge both collections and remove duplicates if necessary
        $userIds = $employeeUserIds->merge($pesoUserIds)->unique();

        $auditsQuery = Audit::query();

        // Apply filter based on the selected filter and municipality_id
        if ($this->filter === '1') {
            $auditsQuery->where('user_id', 0); // System
        } elseif ($this->filter === '2') {

            $jobPostings = Job_Posting::whereHas('peso', function ($query) use ($municipalityId) {
                $query->where('municipality_id', $municipalityId);
            })->pluck('job_id');

            $auditsQuery = Audit::query()
                ->where('auditable_type', Job_Posting::class)
                ->whereIn('auditable_id', $jobPostings); // Filter by the job posting IDs
        } elseif ($this->filter === '3') {

            $jobApplicants = Job_Applicants::whereHas('job_posting', function ($query) use ($municipalityId) {
                $query->whereHas('peso', function ($query) use ($municipalityId) {
                    $query->where('municipality_id', $municipalityId);
                });
            })->pluck('applicant_id');
            $auditsQuery = Audit::query()
                ->where('auditable_type', Job_Applicants::class)
                ->whereIn('auditable_id', $jobApplicants); // Filter by the job posting IDs
        } elseif ($this->filter === '4') {

            $programs = Programs::whereHas('peso', function ($query) use ($municipalityId) {
                $query->where('municipality_id', $municipalityId);
            })->pluck('program_id');

            $auditsQuery = Audit::query()
                ->where('auditable_type', Programs::class)
                ->whereIn('auditable_id', $programs); // Filter by the job posting IDs
        } elseif ($this->filter === '5') {

            $programReg = Program_Reg::whereHas('programs', function ($query) use ($municipalityId) {
                $query->whereHas('peso', function ($query) use ($municipalityId) {
                    $query->where('municipality_id', $municipalityId);
                });
            })->pluck('program_reg_id');

            $auditsQuery = Audit::query()
                ->where('auditable_type', Program_Reg::class)
                ->whereIn('auditable_id', $programReg); // Filter by the job posting IDs

        } elseif ($this->filter === '6') {

            $announcements = Announcements::whereHas('peso', function ($query) use ($municipalityId) {
                $query->where('municipality_id', $municipalityId);
            })->pluck('announcement_id');

            $auditsQuery = Audit::query()
                ->where('auditable_type', Announcements::class)
                ->whereIn('auditable_id', $announcements); // Filter by the job posting IDs
        } elseif ($this->filter === '7') {
            $auditsQuery->whereIn('user_id', $employeeUserIds);
        } else {
            // Default case: Include all audits related to employees and other criteria
            $auditsQuery->where(function ($query) use ($userIds, $municipalityId) {
                $query->whereIn('user_id', $userIds)
                    ->orWhere(function ($query) use ($municipalityId) {
                        $query->whereIn('auditable_type', [
                            Job_Posting::class,
                            Job_Applicants::class,
                            Programs::class,
                            Program_Reg::class,
                            Announcements::class,
                        ])
                            ->where(function ($query) use ($municipalityId) {
                                $query->orWhereHasMorph('auditable', [Job_Posting::class], function ($query) use ($municipalityId) {
                                    $query->whereHas('peso', function ($q) use ($municipalityId) {
                                        $q->where('municipality_id', $municipalityId);
                                    });
                                })
                                    ->orWhereHasMorph('auditable', [Job_Applicants::class], function ($query) use ($municipalityId) {
                                        $query->whereHas('job_posting.peso', function ($q) use ($municipalityId) {
                                            $q->where('municipality_id', $municipalityId);
                                        });
                                    })
                                    ->orWhereHasMorph('auditable', [Programs::class], function ($query) use ($municipalityId) {
                                        $query->whereHas('peso', function ($q) use ($municipalityId) {
                                            $q->where('municipality_id', $municipalityId);
                                        });
                                    })
                                    ->orWhereHasMorph('auditable', [Program_Reg::class], function ($query) use ($municipalityId) {
                                        $query->whereHas('programs.peso', function ($q) use ($municipalityId) {
                                            $q->where('municipality_id', $municipalityId);
                                        });
                                    })
                                    ->orWhereHasMorph('auditable', [Announcements::class], function ($query) use ($municipalityId) {
                                        $query->whereHas('peso', function ($q) use ($municipalityId) {
                                            $q->where('municipality_id', $municipalityId);
                                        });
                                    });
                            });
                    });
            });
        }

        $audits = $auditsQuery->latest()->paginate(10);

        // Format the audits using AuditFormatter
        $formattedAudits = $audits->map(function ($audit) {
            return AuditFormatter::format($audit);
        });

        return view('livewire.admin.maintenance.municipality-audits', compact('formattedAudits', 'audits'));
    }
}
