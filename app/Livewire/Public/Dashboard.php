<?php

namespace App\Livewire\Public;

use App\Models\Announcements;
use App\Models\Barangay;
use App\Models\Disability;
use App\Models\Education;
use App\Models\Industry_preference;
use App\Models\Job_Industry;
use App\Models\Job_Positions;
use App\Models\Job_Posting;
use App\Models\Job_Preference;
use App\Models\Partnerships;
use App\Models\PESO;
use App\Models\Programs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $eduLevels = [
        '0' => 'NONE',
        '1' => 'GRADE I',
        '2' => 'GRADE II',
        '3' => 'GRADE III',
        '4' => 'GRADE IV',
        '5' => 'GRADE V',
        '6' => 'GRADE VI',
        '7' => 'GRADE VII',
        '8' => 'GRADE VIII',
        '9' => 'ELEMENTARY GRADUATE',
        '10' => '1ST YEAR HIGH SCHOOL/GRADE VII (FOR K TO 12)',
        '11' => '2ND YEAR HIGH SCHOOL/GRADE VIII (FOR K TO 12)',
        '12' => '3RD YEAR HIGH SCHOOL/GRADE IX (FOR K TO 12)',
        '13' => '4TH YEAR HIGH SCHOOL/GRADE X (FOR K TO 12)',
        '14' => 'GRADE XI (FOR K TO 12)',
        '15' => 'GRADE XII (FOR K TO 12)',
        '16' => 'HIGH SCHOOL GRADUATE',
        '17' => 'VOCATIONAL UNDERGRADUATE',
        '18' => 'VOCATIONAL GRADUATE',
        '19' => '1ST YEAR COLLEGE LEVEL',
        '20' => '2ND YEAR COLLEGE LEVEL',
        '21' => '3RD YEAR COLLEGE LEVEL',
        '22' => '4TH YEAR COLLEGE LEVEL',
        '23' => '5TH YEAR COLLEGE LEVEL',
        '24' => 'COLLEGE GRADUATE',
        '25' => 'MASTERAL/POST GRADUATE LEVEL',
        '26' => 'MASTERAL/POST GRADUATE',
    ];

    public $jobTypes = [
        '0' => 'None',
        '1' => 'Full Time',
        '2' => 'Contractual',
        '3' => 'Part Time',
        '4' => 'Project-Based',
        '5' => 'Internship/OJT',
        '6' => 'Work From Home',
    ];

    public $search, $searchIndustry, $searchTags;
    public $filter = 'All';

    public $jobTypeFilter;
    public $sort = 'Newest';
    public $pagination = 8;

    public $filterJobTags = [], $filterIndustry = [], $mountJobTagsFilter = [], $mountIndustryFilter = [];

    public function mountJobTags()
    {
        $this->filterJobTags = $this->mountJobTagsFilter;
        $this->dispatch('close-modal', 'job-tag-filter-modal');
        $this->resetPage('jobs');

        if (Auth::check() && Auth::user()->usertype && !in_array(Auth::user()->usertype, [5, 6, 11])) {
            $this->updateFilter('My Municipality');
        }

    }
    public function mountIndustry()
    {
        $this->filterIndustry = $this->mountIndustryFilter;
        $this->dispatch('close-modal', 'industry-filter-modal');
        $this->resetPage('jobs');
        if (Auth::check() && Auth::user()->usertype && !in_array(Auth::user()->usertype, [5, 6, 11])) {
            $this->updateFilter('My Municipality');
        }

    }

    public function resetJobTags()
    {
        $this->reset('filterJobTags', 'mountJobTagsFilter');
        $this->resetPage('job_position');
        $this->resetPage('jobs');

    }
    public function resetIndustry()
    {
        $this->reset('filterIndustry', 'mountIndustryFilter');
        $this->resetPage('job_industry');
        $this->resetPage('jobs');

    }
    public function updatedSearch()
    {
        $this->resetPage('jobs');
    }
    public function updatedsearchIndustry()
    {
        $this->resetPage('job_industry');
    }
    public function updatedsearchTags()
    {
        $this->resetPage('job_position');
    }
    public function mount()
    {
        $this->initializeFilter();
    }

    private function initializeFilter()
    {
        $user = Auth::user();
        if ($user) {
            if ($user->usertype == 4) {
                $this->filter = 'Recommended';
            } elseif ($user->usertype >= 8 && $user->usertype < 11) {
                $this->filter = 'My Municipality';
            } else {
                $this->filter = 'All';
            }
        }
    }
    public function mountTopJobTags($value)
    {

        $this->resetPage('jobs');
        $this->search = $value;
        if (Auth::check() && Auth::user()->usertype && !in_array(Auth::user()->usertype, [5, 6, 11])) {
            $this->updateFilter('My Municipality');
        }
    }
    public function updateFilter($value)
    {
        $this->filter = $value;
        $this->sort = 'Newest';
        $this->resetPage('jobs');
    }

    public function updateSort($value)
    {
        $this->sort = $value;
        $this->resetPage('jobs');

    }

    public function updateJobType($value)
    {
        $this->jobTypeFilter = $value;
        $this->resetPage('jobs');
    }

    private function getHighestEducationLevel()
    {
        $user = Auth::user();
        return Education::where('employee_id', $user->employee->employee_id)
            ->max('edu_Level');
    }

    private function getUserMunicipalityId()
    {
        $user = Auth::user();
        return Barangay::where('barangay_id', $user->employee->barangay_id)
            ->value('municipality_id');
    }

    private function getUserJobPreferences()
    {
        $user = Auth::user();
        return Job_Preference::where('employee_id', $user->employee->employee_id)
            ->pluck('position_id');
    }

    private function getUserIndustryPreference()
    {
        $user = Auth::user();
        return Industry_Preference::where('employee_id', $user->employee->employee_id)
            ->pluck('industry_id');
    }

    private function checkUserDisability()
    {
        $user = Auth::user();

        // Check if there is a disability record for the user
        $hasDisability = Disability::where('employee_id', $user->employee->employee_id)->exists();

        return $hasDisability ? 1 : 2; // Return 1 if a record exists, otherwise return 2
    }

    private function buildJobQuery()
    {
        $query = Job_Posting::with([
            'company',
            'job_tags.job_positions',
            'barangay.municipality',
            'peso.municipality',
            'job_industry',
        ])
            ->where('job_Status', 'ACTIVE');

        $user = Auth::user();

        if ($this->filter == 'Recommended') {
            // Get the highest education level of the user
            $highestEducationLevel = $this->getHighestEducationLevel();
            $userMunicipalityId = $this->getUserMunicipalityId();
            $userJobPreferences = $this->getUserJobPreferences();
            $userIndustryPreference = $this->getUserIndustryPreference();
            $userHasDisability = $this->checkUserDisability();

            // Query for matching job postings
            $query
                ->whereHas('peso.municipality', function ($query) use ($userMunicipalityId) {
                    $query->where('municipality_id', $userMunicipalityId);
                })
                ->where('job_Edu', '<=', $highestEducationLevel)
                ->where(function ($query) use ($userJobPreferences, $userIndustryPreference) {
                    $query->where(function ($query) use ($userJobPreferences, $userIndustryPreference) {
                        $query->whereHas('job_tags', function ($q) use ($userJobPreferences) {
                            $q->whereIn('position_id', $userJobPreferences);
                        })
                            ->whereHas('job_industry', function ($q) use ($userIndustryPreference) {
                                $q->whereIn('industry_id', $userIndustryPreference);
                            });
                    })
                        ->orWhere(function ($query) use ($userIndustryPreference) {
                            $query->whereHas('job_industry', function ($q) use ($userIndustryPreference) {
                                $q->whereIn('industry_id', $userIndustryPreference);
                            });
                        })
                        ->orWhere(function ($query) use ($userJobPreferences) {
                            $query->whereHas('job_tags', function ($q) use ($userJobPreferences) {
                                $q->whereIn('position_id', $userJobPreferences);
                            });
                        });
                })
                ->withCount(['job_tags as job_tags_count' => function ($query) use ($userJobPreferences) {
                    $query->whereIn('position_id', $userJobPreferences);
                }])
                ->withCount(['job_industry as industry_count' => function ($query) use ($userIndustryPreference) {
                    $query->whereIn('industry_id', $userIndustryPreference);
                }])
                ->orderByRaw('
            CASE
                -- Prioritize jobs accepting disabilities if the user has a disability
                WHEN job_Disability = 1 AND ? = 1 AND industry_count > 0 AND job_tags_count > 0 THEN 1
                WHEN job_Disability = 1 AND ? = 1 AND industry_count > 0 AND job_tags_count = 0 THEN 2
                WHEN job_Disability = 1 AND ? = 1 AND industry_count = 0 AND job_tags_count > 0 THEN 3
                -- Rank jobs normally if the user has no disability
                WHEN industry_count > 0 AND job_tags_count > 0 THEN 4
                WHEN industry_count > 0 AND job_tags_count = 0 THEN 5
                WHEN industry_count = 0 AND job_tags_count > 0 THEN 6
                ELSE 7
            END
        ', [$userHasDisability, $userHasDisability, $userHasDisability])
                ->orderByDesc('job_tags_count')
                ->distinct();
            // dd($query->get(), $userJobPreferences, $userIndustryPreference, $highestEducationLevel, $userMunicipalityId);

        } elseif ($this->filter === 'My Municipality') {
            $municipalityId = $user->usertype == 4
            ? $user->employee->barangay->municipality->municipality_id
            : $user->peso_accounts->peso->municipality_id;

            $query->whereHas('peso.municipality', function ($query) use ($municipalityId) {
                $query->where('municipality_id', $municipalityId);
            });
        }

        // Apply the job_tags and industry filters
        if (!empty($this->filterJobTags)) {
            $query->whereHas('job_tags', function ($query) {
                $query->whereIn('position_id', $this->filterJobTags);
            });
        }

        if (!empty($this->filterIndustry)) {
            $query->whereHas('job_industry', function ($query) {
                $query->whereIn('industry_id', $this->filterIndustry);
            });
        }

        if ($this->search) {
            $query->where(function ($query) {
                $query->whereHas('company', function ($query) {
                    $query->where('business_Name', 'like', '%' . $this->search . '%')
                        ->orWhere('trade_Name', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('job_Title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('job_tags.job_positions', function ($query) {
                        $query->where('position_Title', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('job_industry', function ($query) {
                        $query->where('industry_Title', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('peso.municipality', function ($query) {
                        $query->where('municipality_name', 'like', '%' . $this->search . '%');
                    });
            });

        }
        if ($this->jobTypeFilter) {
            $query->where('job_Type', $this->jobTypeFilter);
        }

        return $query;
    }

    private function getPaginatedJobs()
    {
        $query = $this->buildJobQuery();

        switch ($this->sort) {
            case 'Newest':
                $query->orderBy('created_at', 'DESC');
                break;
            case 'Oldest':
                $query->orderBy('created_at', 'ASC');
                break;

        }

        return $query->paginate($this->pagination, ['*'], 'jobs');
    }

    public function companyNotifications($empID)
    {
        // Fetch job postings and applicants notifications
        $jobPostingsAndApplicants = DB::table('job_posting')
            ->leftJoin('job_applicants', 'job_posting.job_id', '=', 'job_applicants.job_id')
            ->select(
                'job_posting.job_id',
                'job_posting.job_title',
                'job_posting.responded_at as job_responded_at',
                'job_applicants.responded_at as applicant_responded_at',
                'job_applicants.applicant_Status as applicant_status',
                'job_applicants.updated_at as applicant_updated_at' // Include updated_at for accepted date
            )
            ->where('job_posting.company_id', $empID)
            ->where(function ($query) {
                $query->whereNotNull('job_posting.responded_at')
                    ->orWhereNotNull('job_applicants.responded_at');
            })
            ->where('job_applicants.applicant_Status', '!=', 'ACCEPTED')

            ->orderBy('job_posting.responded_at', 'desc')
            ->orderBy('job_applicants.responded_at', 'desc')
            ->get();

        // Fetch partnerships notifications
        $partnerships = DB::table('partnerships')
            ->leftJoin('peso', 'partnerships.peso_id', '=', 'peso.peso_id')
            ->leftJoin('municipality', 'peso.municipality_id', '=', 'municipality.municipality_id')
            ->select(
                'partnerships.responded_at as partnership_responded_at',
                'partnerships.partnership_Status as partnership_status',
                'municipality.municipality_Name'
            )
            ->where('partnerships.company_id', $empID)
            ->whereNotNull('partnerships.responded_at')
            ->orderBy('partnerships.responded_at', 'desc')
            ->get();

        // Fetch accepted applicants notifications
        $acceptedApplicants = DB::table('job_applicants')
            ->join('job_posting', 'job_applicants.job_id', '=', 'job_posting.job_id')
            ->select(
                'job_posting.job_title',
                'job_applicants.applicant_Status as applicant_status',
                'job_applicants.updated_at as applicant_updated_at',
                'job_posting.job_id'
            )
            ->where('job_posting.company_id', $empID)
            ->where('job_applicants.applicant_Status', 'ACCEPTED')
            ->orderBy('job_applicants.updated_at', 'desc')
            ->get();

        // Merge notifications
        $notifications = $jobPostingsAndApplicants->merge($partnerships)->merge($acceptedApplicants);

        // Format notifications
        $formattedNotifications = $notifications->map(function ($notification) {
            if (isset($notification->partnership_responded_at)) {
                // Handle partnership notifications
                $type = 'partnership';
                $status = $notification->partnership_status;
                $respondedAt = $notification->partnership_responded_at;
                $municipalityName = $notification->municipality_Name;
                $message = match ($status) {
                    'REJECTED' => 'Your partnership application with PESO ' . $municipalityName . ' has been rejected.',
                    'APPROVED' => 'Your partnership application with PESO ' . $municipalityName . ' has been accepted.',
                    'CANCELLED' => 'Partnership with PESO ' . $municipalityName . ' has been cancelled.',
                    default => 'Status unknown.',
                };
            } elseif (isset($notification->applicant_updated_at) && $notification->applicant_status === 'ACCEPTED') {
                // Handle accepted job applicant notifications
                $type = 'applicant';
                $status = $notification->applicant_status;
                $respondedAt = $notification->applicant_updated_at; // Use updated_at for accepted applications
                $message = 'An applicant has accepted your offer for the job "' . $notification->job_title . '".';
                $municipalityName = null;
            } elseif (isset($notification->applicant_responded_at)) {
                // Handle job applicant notifications
                $type = 'applicant';
                $status = $notification->applicant_status;
                $respondedAt = $notification->applicant_responded_at;
                $message = 'A new applicant has applied for your job "' . $notification->job_title . '".';
                $municipalityName = null;
            } else {
                // Handle job posting notifications
                $type = 'posting';
                $status = null;
                $respondedAt = $notification->job_responded_at;
                $message = 'The job post application for "' . $notification->job_title . '" has been responded to.';
                $municipalityName = null;
            }

            return [
                'type' => $type,
                'status' => $status,
                'job_title' => $notification->job_title ?? null,
                'responded_at' => $respondedAt,
                'message' => $message,
                'municipality_Name' => $municipalityName,
            ];
        });

        // Order notifications by responded_at in descending order
        $formattedNotifications = $formattedNotifications->sortByDesc('responded_at')->values()->toArray();

        return $formattedNotifications;
    }

    public function getAnnouncements($pesoId = null)
    {
        $query = Announcements::query();

        if ($pesoId) {
            $query->where('peso_id', $pesoId);

        }
        return $query->where('announcement_Status', 'ACTIVE')->latest()->limit(3)->get();
    }

    public function setAnnouncements($user = null)
    {
        // Check if a user is provided and authenticated
        if ($user && $user->employee) {
            // Fetch PESO ID based on employee's municipality
            $peso = PESO::where('municipality_id', $user->employee->barangay->municipality_id)->first();
            $pesoId = $peso ? $peso->peso_id : null;
        } elseif ($user && $user->peso_accounts) {
            // Fetch PESO ID based on user's PESO account
            $pesoId = $user->peso_accounts->peso_id;
        } else {
            // If no user or not logged in, set PESO ID to null and fetch all announcements
            $pesoId = null;
        }

        // Return announcements based on the PESO ID or fetch all if no specific PESO ID
        return $this->getAnnouncements($pesoId);
    }

    private function buildProgramQuery()
    {
        $query = Programs::with([
            'program_tags.job_positions',
            'job_industry',
            'peso.municipality',
        ])->where('program_Status', 'ACTIVE');

        if (Auth::check()) {
            $user = Auth::user();

            // Get user preferences
            if ($user->employee) {
                $userJobPreferences = $this->getUserJobPreferences();
                $userIndustryPreference = $this->getUserIndustryPreference();
                $userMunicipalityId = $this->getUserMunicipalityId();

                $query->whereHas('peso.municipality', function ($q) use ($userMunicipalityId) {
                    $q->where('municipality_id', $userMunicipalityId);
                })
                    ->where(function ($query) use ($userJobPreferences, $userIndustryPreference) {
                        $query->where(function ($query) use ($userJobPreferences, $userIndustryPreference) {
                            $query->whereHas('program_tags.job_positions', function ($q) use ($userJobPreferences) {
                                $q->whereIn('position_id', $userJobPreferences);
                            })
                                ->whereHas('job_industry', function ($q) use ($userIndustryPreference) {
                                    $q->whereIn('industry_id', $userIndustryPreference);
                                });
                        })
                            ->orWhere(function ($query) use ($userIndustryPreference) {
                                $query->whereHas('job_industry', function ($q) use ($userIndustryPreference) {
                                    $q->whereIn('industry_id', $userIndustryPreference);
                                });
                            })
                            ->orWhere(function ($query) use ($userJobPreferences) {
                                $query->whereHas('program_tags.job_positions', function ($q) use ($userJobPreferences) {
                                    $q->whereIn('position_id', $userJobPreferences);
                                });
                            });
                    })
                    ->withCount(['program_tags as tags_count' => function ($query) use ($userJobPreferences) {
                        $query->whereIn('position_id', $userJobPreferences);
                    }])
                    ->withCount(['job_industry as industry_count' => function ($query) use ($userIndustryPreference) {
                        $query->whereIn('industry_id', $userIndustryPreference);
                    }])
                    ->orderByRaw('
                CASE
                    WHEN industry_count > 0 AND tags_count > 0 THEN 1
                    WHEN industry_count > 0 AND tags_count = 0 THEN 2
                    WHEN industry_count = 0 AND tags_count > 0 THEN 3
                    ELSE 4
                END
            ')
                    ->orderByDesc('tags_count')
                    ->orderByDesc('industry_count')
                    ->distinct();

            } elseif ($user->employee || $user->peso_accounts) {
                $municipalityId = $user->usertype == 4 ?
                $user->employee->barangay->municipality->municipality_id :
                $user->peso_accounts->peso->municipality_id;

                $query->whereHas('peso.municipality', function ($q) use ($municipalityId) {
                    $q->where('municipality_id', $municipalityId);
                });
            }
        }

        return $query;
    }

    public function getRecommendedPrograms()
    {
        $programQuery = $this->buildProgramQuery();
        return $programQuery->orderBy('created_at', 'desc')->take(4)->get();
    }
    public function getTopJobTags($user = null)
    {
        // Determine the municipality ID based on user status
        if ($user && $user->employee) {
            // Fetch municipality ID based on employee's municipality
            $municipalityId = $user->employee->barangay->municipality_id;
        } elseif ($user && $user->peso_accounts) {
            // Fetch municipality ID based on user's PESO account
            $municipalityId = $user->peso_accounts->peso->municipality_id;
        } else {
            // If no user or not logged in, set municipality ID to null
            $municipalityId = null;
        }

        // Fetch top job positions based on active job postings
        $jobPositions = Job_Positions::whereHas('job_tags.job_posting', function ($query) use ($municipalityId) {
            // Ensure job postings are ACTIVE
            $query->where('job_Status', 'ACTIVE')
                ->when($municipalityId, function ($query) use ($municipalityId) {
                    // Filter by municipality if available
                    $query->whereHas('peso.municipality', function ($subQuery) use ($municipalityId) {
                        $subQuery->where('municipality_id', $municipalityId);
                    });
                });
        })
        // Count active job postings associated with each position
            ->withCount(['job_tags as active_job_posting_count' => function ($query) use ($municipalityId) {
                $query->whereHas('job_posting', function ($subQuery) use ($municipalityId) {
                    $subQuery->where('job_Status', 'ACTIVE') // Count only active postings
                        ->when($municipalityId, function ($subQuery) use ($municipalityId) {
                            // Filter by municipality if available
                            $subQuery->whereHas('peso.municipality', function ($subQuery) use ($municipalityId) {
                                $subQuery->where('municipality_id', $municipalityId);
                            });
                        });
                });
            }])
            ->orderBy('active_job_posting_count', 'desc') // Order by count of active job postings
            ->take(5) // Limit to top 5 positions
            ->get();

        return $jobPositions;
    }

    public function getTopJobIndustries($user = null)
    {
        // Determine the municipality ID based on user status
        if ($user && $user->employee) {
            // Fetch municipality ID based on employee's municipality
            $municipalityId = $user->employee->barangay->municipality_id;
        } elseif ($user && $user->peso_accounts) {
            // Fetch municipality ID based on user's PESO account
            $municipalityId = $user->peso_accounts->peso->municipality_id;
        } else {
            // If no user or not logged in, set municipality ID to null
            $municipalityId = null;
        }

        // Fetch top job industries based on active job postings and municipality
        $jobIndustries = Job_Industry::whereHas('job_posting', function ($query) use ($municipalityId) {
            $query->where('job_Status', 'ACTIVE') // Ensure job postings are ACTIVE
                ->when($municipalityId, function ($query) use ($municipalityId) {
                    $query->whereHas('peso.municipality', function ($subQuery) use ($municipalityId) {
                        $subQuery->where('municipality_id', $municipalityId); // Filter by municipality if available
                    });
                });
        })
        // Count only active job postings associated with each industry
            ->withCount(['job_posting as active_job_posting_count' => function ($query) use ($municipalityId) {
                $query->where('job_Status', 'ACTIVE') // Count only active postings
                    ->when($municipalityId, function ($query) use ($municipalityId) {
                        $query->whereHas('peso.municipality', function ($subQuery) use ($municipalityId) {
                            $subQuery->where('municipality_id', $municipalityId); // Filter by municipality if available
                        });
                    });
            }])

            ->orderBy('active_job_posting_count', 'desc') // Order by count of active job postings
            ->take(5) // Limit to top 5 industries
            ->get();

        return $jobIndustries;
    }

    public function checkPartnerships($user)
    {

        return Partnerships::where('company_id', $user->company->company_id)
            ->where('partnership_Status', 'APPROVED')
            ->exists(); // This will return true if a record exists, otherwise false

    }

    public function render()
    {
        $joblist = $this->getPaginatedJobs();
        // $programList = Programs::orderBy('created_at', 'desc')->take(4)->get();
        $programList = $this->buildProgramQuery()->orderBy('created_at', 'desc')->take(4)->get();

        $user = Auth::user();
        $formattedNotifications = $user && $user->company ? $this->companyNotifications($user->company->company_id) : [];

        $jobposition = Job_Positions::where('position_Status', 1)->where('position_Title', 'like', '%' . $this->searchTags . '%')
            ->paginate(8, ['*'], 'job_position');
        $industry = Job_Industry::where('industry_Status', 1)->where('industry_Title', 'like', '%' . $this->searchIndustry . '%')
            ->paginate(8, ['*'], 'job_industry');

        $announcements = $this->setAnnouncements($user);
        $topJobTags = $this->getTopJobTags($user);
        $topJobIndustries = $this->getTopJobIndustries($user);

        $activePartnership = true;

        if ($user && ($user->usertype >= 6 && $user->usertype < 8) && $user->company) {
            $activePartnership = $this->checkPartnerships($user);
            // dd($activePartnership);
        }

        return view('livewire.public.dashboard', compact('joblist', 'programList', 'formattedNotifications', 'announcements', 'jobposition', 'industry', 'topJobTags', 'topJobIndustries', 'activePartnership'));
    }
}
