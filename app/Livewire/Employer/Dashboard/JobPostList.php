<?php

namespace App\Livewire\Employer\Dashboard;

use App\Models\Job_Posting;
use App\Models\Partnerships;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class JobPostList extends Component
{

    use WithPagination, WithoutUrlPagination;
    public $search;

    public $filter = 'ALL', $sortDate;
    public function changeFilter($filter)
    {
        $this->filter = $filter;
        $this->reset('sortDate');
    }

    public function updateSort($sort)
    {
        $this->sortDate = $sort;
    }

    public function editJobPost($id)
    {
        session()->put('jobpostData', $id);

        $this->redirectRoute('jobpost.edit', navigate: true);

    }

    public function checkPartnerships($user)
    {

        return Partnerships::where('company_id', $user->company->company_id)
            ->where('partnership_Status', 'APPROVED')
            ->exists(); // This will return true if a record exists, otherwise false
    }

    public function render()
    {
        $user = Auth::user();

        $applicantsQuery = Job_Posting::withCount([
            'job_applicants as pending_count' => function ($query) {
                $query->where('applicant_Status', 'PENDING')
                    ->whereNot('peso_Status', 'PENDING');
            },
            'job_applicants as interested_count' => function ($query) {
                $query->where('applicant_Status', 'INTERESTED')
                    ->whereNot('peso_Status', 'PENDING');
            },
            'job_applicants as interview_count' => function ($query) {
                $query->where('applicant_Status', 'INTERVIEW')
                    ->whereNot('peso_Status', 'PENDING');
            }, 'job_applicants as hired_count' => function ($query) {
                $query->where('applicant_Status', 'HIRED')
                    ->whereNot('peso_Status', 'PENDING');
            }, 'job_applicants as accepted_count' => function ($query) {
                $query->where('applicant_Status', 'ACCEPTED')
                    ->whereNot('peso_Status', 'PENDING');
            }, 'job_applicants as rejected_count' => function ($query) {
                $query->whereIn('applicant_Status', ['REJECTED', 'CANCELLED'])
                    ->whereNot('peso_Status', 'PENDING');
            },
        ])->where('company_id', $user->company->company_id)
            ->where(function ($query) {
                $query->where('job_Title', 'like', '%' . $this->search . '%');
            });

        if ($this->filter != 'ALL') {
            if ($this->filter == 'OTHERS') {
                $applicantsQuery = $applicantsQuery->whereNotIn('job_status', ['PENDING', 'ACTIVE', 'CLOSED', 'COMPLETED']);
            } else {
                $applicantsQuery = $applicantsQuery->where('job_status', $this->filter);
            }
        }

        if ($this->sortDate !== null && $this->sortDate !== '') {
            $applicantsQuery->orderBy('created_at', $this->sortDate);
        }

        $applicants = $applicantsQuery->paginate(5);

        $allCount = Job_Posting::where('company_id', $user->company->company_id)->count();
        $activeCount = Job_Posting::where('company_id', $user->company->company_id)->where('job_status', 'ACTIVE')->count();
        $pendingCount = Job_Posting::where('company_id', $user->company->company_id)->where('job_status', 'PENDING')->count();
        $closedCount = Job_Posting::where('company_id', $user->company->company_id)->where('job_status', 'CLOSED')->count();
        $completedCount = Job_Posting::where('company_id', $user->company->company_id)->where('job_status', 'COMPLETED')->count();
        $othersCount = Job_Posting::where('company_id', $user->company->company_id)
            ->whereIn('job_status', ['REJECTED', 'CANCELLED'])->count();

        $activePartnership = true;

        if ($user && ($user->usertype >= 6 && $user->usertype < 8) && $user->company) {
            $activePartnership = $this->checkPartnerships($user);
        }

        return view('livewire.employer.dashboard.job-post-list', compact('applicants', 'allCount', 'pendingCount', 'activeCount', 'closedCount', 'completedCount', 'othersCount', 'activePartnership'));
    }
}
