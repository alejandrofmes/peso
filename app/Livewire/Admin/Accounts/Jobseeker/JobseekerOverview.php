<?php

namespace App\Livewire\Admin\Accounts\Jobseeker;

use App\Helpers\AuditFormatter;
use App\Mail\AdminDeactivationNotification;
use App\Mail\AdminResetPasswordNotification;
use App\Models\Barangay;
use App\Models\Disability;
use App\Models\Education;
use App\Models\Employee;
use App\Models\Industry_preference;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use App\Models\Job_Preference;
use App\Models\Program_Reg;
use App\Models\Work_Exp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;

#[Layout('layouts.admin')]
class JobseekerOverview extends Component
{

    use WithPagination;
    use WithoutUrlPagination;

    public $id;

    public $searchApplications, $searchEvents, $searchJobs;

    // SETTING FIELD
    public $fname, $lname, $mname, $suffix, $birthdate, $gender, $civilstatus, $religion;

    public $agreeBox = false, $deactivateBox = false;
    public $deactRemarks, $reactRemarks;

    public function updatedsearchApplications()
    {
        $this->resetPage('applicants'); // Reset pagination for eligibility search
    }

    public function updatedsearchEvents()
    {
        $this->resetPage('history'); // Reset pagination for eligibility search
    }
    public function updatedsearchJobs()
    {
        $this->resetPage('recommended'); // Reset pagination for eligibility search
    }

    public function mount()
    {
        $user = Auth::user();
        $jobseeker = Employee::findOrFail($this->id);

        if (!$jobseeker) {
            return $this->redirectRoute('dashboard');
        }

        // Get the current admin's municipality ID
        $currentAdminMunicipalityId = $user->peso_accounts->peso->municipality_id;

        // Check if the jobseeker's barangay is in the current admin's municipality
        $isInAdminMunicipality = $jobseeker->barangay->municipality_id == $currentAdminMunicipalityId;

        // Check if the jobseeker has any job applications in the current admin's municipality
        $hasJobApplication = $jobseeker->job_applicants()->whereHas('job_posting', function ($query) use ($currentAdminMunicipalityId) {
            $query->where('peso_id', $currentAdminMunicipalityId);
        })->exists();

        // Redirect to dashboard if neither condition is true
        if (!$isInAdminMunicipality && !$hasJobApplication) {
            return $this->redirectRoute('dashboard');
        }

        $this->mountFields($jobseeker);

    }

    public function viewFile($id, $fileToView)
    {

        $this->dispatch('viewFile', [
            'url' => route('view.resume'),
            'emp_id' => $id,
            'resume_type' => $fileToView,
        ]);

    }
    public function statusUser($type)
    {
        // Define validation rules and messages based on the type
        if ($type == 1) {
            $rules = ['reactRemarks' => 'required|string'];
            $messages = [
                'reactRemarks.required' => 'Reactivation remarks are required.',
                'reactRemarks.string' => 'Reactivation remarks must be a valid string.',
            ];
            $this->validate($rules, $messages);
        } elseif ($type == 2) {
            $rules = ['deactRemarks' => 'required|string'];
            $messages = [
                'deactRemarks.required' => 'Deactivation remarks are required.',
                'deactRemarks.string' => 'Deactivation remarks must be a valid string.',
            ];
            $this->validate($rules, $messages);
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Fetch the company and user
            $jobseeker = Employee::findOrFail($this->id);
            $user = $jobseeker->user;

            // Check the type and update user status
            if ($type == 1) {
                $user->userstatus = 1; // Reactivating
                $user->description = $this->reactRemarks; // Set the description
                $user->disabled_at = null;
                $user->save();

                // Uncomment this line if you want to send the notification
                Mail::to($user->email)->queue(new AdminDeactivationNotification('reactivation'));

                toastr()->success('Account is successfully reactivated.');
                $this->closeModal('reactivate');

            } elseif ($type == 2) {
                $user->userstatus = 2; // Deactivating
                $user->description = $this->deactRemarks; // Set the description
                $user->disabled_at = now();
                $user->save();

                $jobseeker->job_applicants()
                    ->whereNotIn('applicant_Status', ['ACCEPTED', 'CANCELLED', 'REJECTED'])
                    ->update([
                        'applicant_Status' => 'CANCELLED',
                        'peso_Status' => 'CANCELLED',
                        'company_Remarks' => 'Account Deactivated',
                        'peso_Remarks' => 'Account Deactivated',
                    ]);

                $jobseeker->program_reg()
                    ->whereHas('programs', function ($query) {
                        $query->where('program_Status', 'ACTIVE');
                    })
                    ->update([
                        'program_reg_Status' => 'CANCELLED',
                    ]);

                // Send notification email for deactivation
                Mail::to($user->email)->queue(new AdminDeactivationNotification('deactivation'));

                toastr()->success('Account is successfully deactivated.');
                $this->closeModal('deactivate');
            }

            DB::commit(); // Commit the transaction if everything is successful

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction if something goes wrong

            Log::error('Error updating reactivation/deactivation: ' . $e->getMessage());
            toastr()->error('There was an error processing the request. Please try again.');
        }
    }

    public function closeModal($modal)
    {
        $this->reset('deactRemarks', 'reactRemarks');
        $this->deactivateBox = false;
        $this->dispatch('close-modal', $modal . '-modal');
    }

    public function recommendedJobs($jobseeker)
    {
        $highestEducationLevel = Education::where('employee_id', $jobseeker->employee_id)
            ->max('edu_Level');

        $userMunicipalityId = Barangay::where('barangay_id', $jobseeker->barangay_id)
            ->value('municipality_id');

        $userJobPreferences = Job_Preference::where('employee_id', $jobseeker->employee_id)
            ->pluck('position_id');

        $userIndustryPreference = Industry_Preference::where('employee_id', $jobseeker->employee_id)
            ->pluck('industry_id');
        $userHasDisability = Disability::where('employee_id', $jobseeker->employee_id)->exists() ? 1 : 2;

        return Job_Posting::with(['company', 'job_tags.job_positions', 'barangay.municipality', 'peso.municipality', 'job_industry'])
            ->where('job_Status', 'ACTIVE')
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
            ->where(function ($query) {
                $query->whereHas('company', function ($query) {
                    $query->where('business_Name', 'like', '%' . $this->searchJobs . '%')
                        ->orWhere('trade_Name', 'like', '%' . $this->searchJobs . '%');
                })
                    ->orWhere('job_Title', 'like', '%' . $this->searchJobs . '%')
                    ->orWhereHas('job_tags.job_positions', function ($query) {
                        $query->where('position_Title', 'like', '%' . $this->searchJobs . '%');
                    })
                    ->orWhereHas('job_industry', function ($query) {
                        $query->where('industry_Title', 'like', '%' . $this->searchJobs . '%');
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
            ->distinct()
            ->orderBy('created_at', 'DESC')
            ->paginate(10, ['*'], 'recommended');
    }

    public function applicationHistory($id)
    {
        return Job_Applicants::with('employee', 'job_posting.company')
            ->where('employee_id', $id)
            ->where(function ($query) {
                $query->whereHas('job_posting', function ($query) {
                    $query->where('job_Title', 'like', '%' . $this->searchApplications . '%')
                        ->orWhereHas('company', function ($query) {
                            $query->where('business_Name', 'like', '%' . $this->searchApplications . '%')
                                ->orWhere('trade_Name', 'like', '%' . $this->searchApplications . '%');
                        });
                });
            })
            ->paginate(5, ['*'], 'applicants');
    }

    public function programHistory($id)
    {
        return $programHistory = Program_Reg::where('employee_id', $id)
            ->where(function ($query) {
                $query->whereHas('programs', function ($query) {
                    $query->where('program_Title', 'like', '%' . $this->searchEvents . '%')
                        ->orWhere('program_Host', 'like', '%' . $this->searchEvents . '%');
                });
            })
            ->paginate(10, ['*'], 'history');
    }

    public function mountFields($jobseeker)
    {
        $this->fname = $jobseeker->fname;
        $this->lname = $jobseeker->lname;
        $this->mname = $jobseeker->mname;
        $this->suffix = $jobseeker->suffix;
        $this->birthdate = Carbon::parse($jobseeker->birthdate)->format('Y-m-d');
        $this->gender = $jobseeker->gender;
        $this->civilstatus = $jobseeker->civilstatus;
        $this->religion = $jobseeker->religion;
    }

    public function saveDetails()
    {

        $rules = [
            'fname' => ['required', 'string'],
            'lname' => ['required', 'string'],
            'birthdate' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->toDateString(), // Must be at least 18 years old
                'before_or_equal:' . now()->toDateString(), // Cannot be in the future
            ],
            'gender' => ['required'],
            'civilstatus' => ['required'],
            'religion' => ['required'],
        ];

        $messages = [
            'fname.required' => 'First name is required.',
            'lname.required' => 'Last name is required.',
            'birthdate.required' => 'Birthdate is required.',
            'birthdate.date' => 'Birthdate must be a valid date.',
            'birthdate.before_or_equal' => 'You must be at least 18 years old.',
            'gender.required' => 'Gender is required.',
            'civilstatus.required' => 'Civil status is required.',
            'religion.required' => 'Religion is required.',
        ];

        $this->validate($rules, $messages);

        $jobseekerData = Employee::findOrFail($this->id);

        DB::beginTransaction();

        try {
            // Delete old image if a new one is uploaded and there is an existing image

            // Update model attributes
            $jobseekerData->fname = $this->fname;
            $jobseekerData->mname = $this->mname;
            $jobseekerData->lname = $this->lname;
            $jobseekerData->suffix = $this->suffix;
            $jobseekerData->gender = $this->gender;
            $jobseekerData->civilstatus = $this->civilstatus;
            $jobseekerData->religion = $this->religion;
            $jobseekerData->birthdate = $this->birthdate;

            // Check if any attributes have changed
            if ($jobseekerData->isDirty()) {
                $jobseekerData->save();

                DB::commit();

                toastr()->success('Jobseeker has been updated!');

            } else {
                DB::rollBack();

                toastr()->info('No changes detected.');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            toastr()->error('There was an error updating the profile.');
        }
        $this->dispatch('close-modal', 'confirm-modal');

    }

    public function generatePassword()
    {
        // Define the password criteria
        $length = 12;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+';

        // Generate a random password
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Set the generated password to the pwdPost property
        return $password;

    }

    public function resetPassword()
    {
        $rules = [
            'agreeBox' => 'required|boolean',
        ];
        $messages = [
            'agreeBox.required' => 'Please check before you continue.',
        ];
        $this->validate($rules, $messages);

        $jobseekerData = Employee::findOrFail($this->id);

        $this->agreeBox = false;
        if ($jobseekerData->user) {
            DB::beginTransaction();

            try {
                // Generate a new password
                $newPassword = $this->generatePassword();

                // Update the user's password (assuming 'password' is the column name)
                $jobseekerData->user->password = Hash::make($newPassword);
                $jobseekerData->user->save();

                DB::commit();

                $name = $jobseekerData->fname . ' ' . $jobseekerData->lname;
                Mail::to($jobseekerData->user->email)->queue(new AdminResetPasswordNotification($name, $newPassword));
                toastr()->success('Password has been reset successfully!');

            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error('There was an error resetting the password.');
            }
        } else {
            toastr()->error('User not found.');
        }
        $this->dispatch('close-modal', 'reset-password-modal');
    }
    public function render()
    {
        $isResident = false;

        $user = Auth::user();
        $jobseeker = Employee::findOrFail($this->id);

        if ($jobseeker->barangay->municipality_id == $user->peso_accounts->peso->municipality_id) {
            $isResident = true;
        }

        $joblist = $this->recommendedJobs($jobseeker);

        $application_history = $this->applicationHistory($jobseeker->employee_id);

        $programHistory = $this->programHistory($jobseeker->employee_id);

        // $this->mountFields($jobseeker);

        $maxEduLevel = $jobseeker->education->max('edu_Level');

        // Get the corresponding education level label
        $educationLabel = $this->eduLevels[$maxEduLevel] ?? 'NONE';

        // Determine the education attainment category
        $attainment = '';

        if ($maxEduLevel >= 9 && $maxEduLevel <= 9) {
            $attainment = 'Elementary Graduate';
        } elseif ($maxEduLevel >= 10 && $maxEduLevel <= 15) {
            $attainment = 'High School Level';
        } elseif ($maxEduLevel == 16) {
            $attainment = 'High School Graduate';
        } elseif ($maxEduLevel >= 19 && $maxEduLevel <= 23) {
            $attainment = 'College Level';
        } elseif ($maxEduLevel == 24) {
            $attainment = 'College Graduate';
        } elseif ($maxEduLevel == 25) {
            $attainment = 'Master Level';
        } elseif ($maxEduLevel == 26) {
            $attainment = 'Master Graduate';
        } else {
            $attainment = 'Other';
        }

        $totalExperience = Work_Exp::getTotalExperience($jobseeker->employee_id);

        $audits = Audit::where('user_id', $jobseeker->user_id)
            ->latest()
            ->paginate(5, ['*'], 'audits');

        $formattedAudits = $audits->map(function ($audit) {
            return AuditFormatter::format($audit);
        });

        return view('livewire.admin.accounts.jobseeker.jobseeker-overview',
            compact('jobseeker',
                'application_history',
                'joblist',
                'programHistory',
                'attainment',
                'totalExperience',
                'audits',
                'formattedAudits',
                'isResident'));
    }
}
