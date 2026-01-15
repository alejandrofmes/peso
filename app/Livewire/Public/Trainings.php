<?php

namespace App\Livewire\Public;

use App\Models\Barangay;
use App\Models\Employee;
use App\Models\Industry_preference;
use App\Models\Job_Preference;
use App\Models\Programs;
use App\Models\Program_Reg;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Trainings extends Component
{

    use WithPagination;
    use WithoutUrlPagination;
    public $ticket = [];
    public $ticketData = [];

    public $search, $searchHistory, $sortType, $sortDate, $filter;

    public $sortTypeHistory, $sortDateHistory;

    public function updatedsearch()
    {
        $this->resetPage('events');
    }

    public function updatedsearchHistory()
    {
        $this->resetPage('trainings');
    }

    public function mount()
    {
        $user = Auth::user();

        if ($user && $user->employee) {
            $this->filter = 'Recommended';
        } else if ($user && ($user->usertype >= 8 && $user->usertype < 11)) {
            $this->filter = 'My Municipality';
        } else {
            $this->filter = 'All';
        }
    }

    public function viewTicket($id)
    {

        $data = Program_Reg::findOrFail($id);

        if ($data) {
            // Prepare the ticket data
            $ticketData = [
                'program_reg_id' => $data->program_reg_id,
                'program_id' => $data->program_id,
                'employee_id' => $data->employee_id,
                'created_at' => $data->created_at->format('Y-m-d H:i:s'), // Explicitly format the timestamp
            ];

            $this->ticketData = [
                'programTitle' => $data->programs->program_Title,
                'programDate' => $data->programs->program_Deadline->format('F j, Y'),
            ];

            // Encrypt the ticket data
            $this->ticket = Crypt::encrypt(json_encode($ticketData));

            $this->dispatch('open-modal', 'ticket-modal');

        }

    }

    public function updateFilter($value)
    {
        $this->filter = $value;
        $this->resetPage('events');

    }
    public function updateSort($value, $type)
    {

        if ($type == 1) {
            $this->sortType = $value;
        } else if ($type == 2) {
            $this->sortDate = $value;
        }
        $this->reset('search');
        $this->resetPage('events');

    }
    public function updateSortHistory($value, $type)
    {

        if ($type == 1) {
            $this->sortTypeHistory = $value;
        } else if ($type == 2) {
            $this->sortDateHistory = $value;
        }
        $this->reset('searchHistory');
        $this->resetPage('trainings');

    }

    public function getRecommended($id)
    {

        $userMunicipalityId = Employee::find($id)->barangay->municipality_id;

        $userJobPreferences = Job_Preference::where('employee_id', $id)
            ->pluck('position_id');

        $userIndustryPreference = Industry_preference::where('employee_id', $id)
            ->pluck('industry_id');

        return Programs::with(['program_tags.job_positions', 'peso.municipality', 'job_industry'])
            ->where('program_Status', 'ACTIVE')
            ->whereHas('peso.municipality', function ($query) use ($userMunicipalityId) {
                $query->where('municipality_id', $userMunicipalityId);
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
            ->where(function ($query) {
                // Additional search filters for company, job title, and position name
                $query
                    ->orWhere('program_Title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('program_tags.job_positions', function ($query) {
                        $query->where('position_Title', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('job_industry', function ($query) {
                        $query->where('industry_Title', 'like', '%' . $this->search . '%');
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
    }

    public function getMunicipailtyPrograms($id)
    {
        return Programs::with(['program_tags.job_positions', 'peso.municipality', 'job_industry'])
            ->where('program_Status', 'ACTIVE')
            ->whereHas('peso.municipality', function ($query) use ($id) {
                $query->where('municipality_id', $id);
            })
            ->where(function ($query) {
                // Additional search filters for company, job title, and position name
                $query
                    ->orWhere('program_Title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('program_tags.job_positions', function ($query) {
                        $query->where('position_Title', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('job_industry', function ($query) {
                        $query->where('industry_Title', 'like', '%' . $this->search . '%');
                    });
            })
            ->distinct();
    }

    public function getProgramList()
    {
        return Programs::with(['program_tags.job_positions', 'peso.municipality', 'job_industry'])
            ->where('program_Status', 'ACTIVE')
            ->where(function ($query) {
                // Additional search filters for company, job title, and position name
                $query
                    ->orWhere('program_Title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('program_tags.job_positions', function ($query) {
                        $query->where('position_Title', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('job_industry', function ($query) {
                        $query->where('industry_Title', 'like', '%' . $this->search . '%');
                    });
            })
            ->distinct();
    }

    private function getMunicipalityId($user)
    {
        if ($user->usertype == 4) {
            return $user->employee->barangay->municipality->municipality_id ?? null;
        } elseif ($user->usertype >= 8 && $user->usertype < 11) {
            return $user->peso_accounts->peso->municipality->municipality_id ?? null;
        }

        return null; // Return null if no valid municipality ID is found
    }

    public function closeTicket()
    {
        $this->dispatch('close-modal', 'ticket-modal');
        $this->reset('ticket', 'ticketData');
    }
    public function render()
    {

        $user = Auth::user();
        $programHistory = null;

        switch ($this->filter) {
            case 'Recommended':
                $query = $this->getRecommended($user->employee->employee_id);
                break;

            case 'My Municipality':
                $municipalityId = $this->getMunicipalityId($user);
                if ($municipalityId) {
                    $query = $this->getMunicipailtyPrograms($municipalityId);
                } else {
                    $query = $this->getProgramList();
                    toastr()->warning('There was an error fetching the municipality.');
                }
                break;

            case 'All':
            default:
                $query = $this->getProgramList();
                break;
        }

        if ($this->sortType) {
            $query->where('program_Type', $this->sortType);
        }
        if ($this->sortDate) {
            $query->orderBy('created_at', $this->sortDate);
        }

        $programList = $query->paginate(9, ['*'], 'events');

        if (Auth::check()) {

            if ($user->employee) {
                // Start the query for Program_Reg
                $query = Program_Reg::where('employee_id', $user->employee->employee_id)
                    ->where(function ($query) {
                        $query->whereHas('programs', function ($query) {
                            // Search by program title or host
                            $query->where('program_Title', 'like', '%' . $this->searchHistory . '%')
                                ->orWhere('program_Host', 'like', '%' . $this->searchHistory . '%');
                        })
                            ->orWhereHas('programs.program_tags.job_positions', function ($query) {
                                // Search by job position title
                                $query->where('position_Title', 'like', '%' . $this->searchHistory . '%');
                            })
                            ->orWhereHas('programs.job_industry', function ($query) {
                                // Search by industry title
                                $query->where('industry_Title', 'like', '%' . $this->searchHistory . '%');
                            });
                    });

                // Apply sorting conditions
                if ($this->sortTypeHistory) {
                    $query->whereHas('programs', function ($query) {
                        $query->where('program_Type', $this->sortTypeHistory);
                    });
                }
                if ($this->sortDateHistory) {
                    $query->orderBy('created_at', $this->sortDateHistory);
                }

                // Paginate the results
                $programHistory = $query->paginate(10, ['*'], 'trainings');
            }
        }

        return view('livewire.public.trainings', compact('programList', 'programHistory'));
    }
}
