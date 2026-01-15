<?php

namespace App\Livewire\Admin\Accounts\Employer;

use App\Helpers\AuditFormatter;
use App\Mail\AdminDeactivationNotification;
use App\Mail\AdminResetPasswordNotification;
use App\Mail\JobCancelledNotification;
use App\Mail\PartnershipCancellationNotification;
use App\Models\Company;
use App\Models\Job_Posting;
use App\Models\Partnerships;
use App\Models\Requirements;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\Artisan;
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
class EmployerOverview extends Component
{

    use WithPagination, WithoutUrlPagination;
    public $id;

    public $searchJobs;

    public $businessName, $tradeName, $TIN, $locType = '', $workforce = '', $empType = '', $empDesc = '';

    public $deactRemarks, $reactRemarks, $partRemarks;

    public $empDescriptions = [];

    public $agreeBox = false, $deactivateBox = false, $cancelPartnership = false;

    public function updatedsearchJobs()
    {
        $this->resetPage(); // Reset pagination for eligibility search
    }

    public function mount()
    {
        $user = Auth::user();

        $partnership = Partnerships::where('company_id', $this->id)
            ->where('peso_id', $user->peso_accounts->peso_id)
            ->first();

        if ($partnership->partnership_Status != 'APPROVED') {
            return $this->redirectRoute('dashboard');
        }
        $employer = Company::findOrFail($this->id);
        $this->mountFields($employer);

    }

    public function updatedEmpType()
    {
        // Reset empDesc when empStatus changes
        $this->empDesc = '';

        // Update empDescriptions based on empStatus
        if ($this->empType == '1') { // Employed
            $this->empDescriptions = [
                ['value' => 1, 'text' => 'National Government Agency'],
                ['value' => 2, 'text' => 'Local Government Unit'],
                ['value' => 3, 'text' => 'Government-owned and Controlled '],
                ['value' => 4, 'text' => 'State/Local University or College'],

            ];
        } elseif ($this->empType == '2') { // Unemployed
            $this->empDescriptions = [
                ['value' => 5, 'text' => 'Direct Hire'],
                ['value' => 6, 'text' => 'Private Employment Agency'],
                // ['value' => 7, 'text' => 'Overseas Recruitment Agency'],
                ['value' => 8, 'text' => 'D.O. 174, s. 2017'],
            ];
        } else {
            $this->empDescriptions = [];
        }
    }

    public function viewFile($reqPassedId)
    {

        $url = route('view.requirement');
        // Dispatch an event to trigger JavaScript for opening a new tab
        $this->dispatch('viewFile', [
            'url' => $url,
            'req_passed_id' => $reqPassedId,

        ]);

    }

    public function updatePartnership()
    {
        // Validate the remarks based on status
        $rules = ['partRemarks' => 'required|string'];
        $messages = ['partRemarks.required' => 'Partnership remarks are required.',
            'partRemarks.string' => 'Partnership remarks must be a valid string.'];

        // Validate input
        $this->validate($rules, $messages);

        // Get the authenticated user
        $user = Auth::user();

        // Start a transaction
        DB::beginTransaction();

        try {
            // Find the partnership record
            $partnership = Partnerships::where('company_id', $this->id)
                ->where('peso_id', $user->peso_accounts->peso_id)
                ->first();

            if (!$partnership) {
                // If no partnership record found, throw an exception
                throw new \Exception('Partnership record not found.');
            }
            // dd($partnership->company->user->email);

            // Update the partnership status and remarks
            $partnership->partnership_Status = 'CANCELLED'; // Update the status
            $partnership->partnership_remarks = $this->partRemarks;
            $partnership->responded_at = now(); // Update the remarks
            // Update the remarks
            $partnership->save();

            // Commit the transaction
            Mail::to($partnership->company->user->email)->queue(new PartnershipCancellationNotification($partnership));
            Artisan::call('partnership:cancel', [
                'companyId' => $this->id,
                'pesoId' => $user->peso_accounts->peso_id,
            ]);

            toastr()->success('Partnership status has been updated successfully.');

            // Optionally, redirect or perform other actions
            $this->closeModal('partnership');
            DB::commit();

            return redirect()->route('dashboard'); // Adjust the route as necessary

        } catch (\Exception $e) {
            // Rollback the transaction on general failure
            DB::rollBack();

            Log::error('Error cancelling partnership: ' . $e->getMessage());
            dd($e->getMessage());

            toastr()->error('Failed to update partnership status. Please try again.'); // Display general error
            $this->closeModal('partnership');

        }
    }
    public function getJobs($peso_id, $id)
    {
        return Job_Posting::withCount(['job_applicants as applicants_count'])
            ->where('company_id', $id)
            ->where('peso_id', $peso_id)
            ->where(function ($query) {
                $query->where('job_Title', 'like', '%' . $this->searchJobs . '%')
                    ->orWhereHas('job_tags.job_positions', function ($query) {
                        $query->where('position_Title', 'like', '%' . $this->searchJobs . '%');
                    })
                    ->orWhereHas('job_industry', function ($query) {
                        $query->where('industry_Title', 'like', '%' . $this->searchJobs . '%');
                    });
            })
            ->paginate(10);
    }

    public function mountFields($employer)
    {
        $this->businessName = $employer->business_Name;
        $this->tradeName = $employer->trade_Name;
        $this->TIN = $employer->company_TIN;
        $this->locType = $employer->company_Type;
        $this->workforce = $employer->company_Total_workforce;
        $this->empType = $employer->employer_Type;
        $this->updatedEmpType();
        $this->empDesc = $employer->employer_Type_Desc;
    }

    public function saveDetails()
    {
        $rules = [
            'businessName' => 'required|string|max:255',
            'tradeName' => 'required|string|max:255',
            'TIN' => 'required|digits:9', // Assuming TIN is exactly 9 digits
            'locType' => 'required', // Example valid types
            'workforce' => 'required', // Nullable, but if present must be an integer and at least 1
            'empType' => 'required', // Example valid types
            'empDesc' => 'required', // Optional, but if present should be a string and max 500 characters
        ];

        $messages = [
            'businessName.required' => 'The business name field is required.',
            'businessName.string' => 'The business name must be a string.',
            'businessName.max' => 'The business name cannot exceed 255 characters.',

            'tradeName.required' => 'The trade name field is required.',
            'tradeName.string' => 'The trade name must be a string.',
            'tradeName.max' => 'The trade name cannot exceed 255 characters.',

            'TIN.required' => 'The TIN field is required.',
            'TIN.digits' => 'The TIN must be exactly 9 digits.',

            'locType.required' => 'The location type field is required.',

            'workforce.required' => 'The workforce field is required.',
            'workforce.integer' => 'The workforce must be an integer.',
            'workforce.min' => 'The workforce must be at least 1.',

            'empType.required' => 'The employer type field is required.',

            'empDesc.required' => 'The employer description field is required.',
        ];

        $this->validate($rules, $messages);

        $companyData = Company::findOrFail($this->id);

        DB::beginTransaction();

        try {

            // Delete old image if a new one is uploaded and there is an existing image

            // Update model attributes
            $companyData->business_Name = $this->businessName;
            $companyData->trade_Name = $this->tradeName;
            $companyData->company_TIN = $this->TIN;
            $companyData->company_Type = $this->locType;
            $companyData->employer_Type = $this->empType;
            $companyData->employer_Type_Desc = $this->empDesc;
            $companyData->company_Total_workforce = $this->workforce;

            // Check if any attributes have changed
            if ($companyData->isDirty()) {
                $companyData->save();
                DB::commit();
                toastr()->success('Company details has been updated!');
            } else {
                DB::rollBack();
                toastr()->info('No changes detected.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('There was an error updating the Company details.');
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
    public function statusUser($type)
    {
        if ($type == 1) {
            $rules = ['reactRemarks' => 'required|string'];
            $messages = ['reactRemarks.required' => 'Reactivation remarks are required.',
                'reactRemarks.string' => 'Reactivation remarks must be a valid string.'];

            $this->validate($rules, $messages);
        } elseif ($type == 2) {
            $rules = ['deactRemarks' => 'required|string'];
            $messages = ['deactRemarks.required' => 'Deactivation remarks are required.',
                'deactRemarks.string' => 'Deactivation remarks must be a valid string.'];

            $this->validate($rules, $messages);
        }

        DB::beginTransaction();

        try {
            // Fetch the company and user
            $company = Company::findOrFail($this->id);
            $user = $company->user;

            // Check the type and update user status
            if ($type == 1) {
                $user->userstatus = 1; // Reactivating
                $user->description = $this->reactRemarks; // Set the description
                $user->disabled_at = null;
                $user->save();
                Mail::to($user->email)->queue(new AdminDeactivationNotification('reactivation'));

                toastr()->success('Account is successfully reactivated.');
                $this->closeModal('reactivate');

            } elseif ($type == 2) {
                $user->userstatus = 2; // Deactivating
                $user->description = $this->deactRemarks; // Set the description
                $user->disabled_at = now();
                $user->save();
                Mail::to($user->email)->queue(new AdminDeactivationNotification('deactivation'));

                $company->job_posting()->whereNotIn('job_Status', ['CANCELLED', 'COMPLETED'])->each(function ($jobPosting) {
                    $jobPosting->update([
                        'job_Status' => 'CANCELLED',
                        'peso_Remarks' => 'ACCOUNT DEACTIVATED',
                    ]);

                    // Update associated job applicants for the cancelled job postings
                    $jobPosting->job_applicants()->update([
                        'applicant_Status' => 'CANCELLED',
                        'company_Remarks' => 'Employer Account Deactivated',
                    ]);

                    // Update pending peso_Status to Cancelled and notify affected applicants
                    $jobPosting->job_applicants()->where('peso_Status', 'PENDING')->each(function ($applicant) {
                        $applicant->update([
                            'peso_Status' => 'CANCELLED',
                            'peso_Remarks' => 'Employer Account Deactivated',
                        ]);

                        // Notify the applicant about the job cancellation
                        Mail::to($applicant->employee->user->email)->queue(new JobCancelledNotification($applicant));
                    });
                });

                toastr()->success('Account is successfully deactivated.');
                $this->closeModal('deactivate');
            }

            DB::commit(); // Commit the transaction if everything is successful

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction if something goes wrong

            // Log the error and show a toastr message
            Log::error('Error updating reactivation/deactivation: ' . $e->getMessage());

            toastr()->error('There was an error processing the request. Please try again.');
        }
    }

    public function closeModal($modal)
    {
        $this->reset('deactRemarks', 'reactRemarks', 'partRemarks');
        $this->deactivateBox = false;
        $this->cancelPartnership = false;
        $this->dispatch('close-modal', $modal . '-modal');
    }

    public function getTopJobTagsByCompany($companyId)
    {
        // Fetch job postings by company with job tags and job positions
        $jobPostings = Job_Posting::where('company_id', $companyId)
            ->with('job_tags.job_positions') // Eager load job_tags and job_positions
            ->get();

        // Flatten and count the job positions' titles from the job tags within the job postings
        $tagCounts = $jobPostings->flatMap(function ($jobpost) {
            return $jobpost->job_tags->map(function ($jobTags) {
                return $jobTags->job_positions->position_Title ?? 'Unknown';
            });
        })->countBy();

        // Get the top 5 job tags by count
        $topJobTags = $tagCounts->sortDesc()->take(5);

        // dd($topJobTags);
        // Prepare data for the column chart
        $columnChartModel = new ColumnChartModel();

        // Add each top tag to the chart
        foreach ($topJobTags as $tagName => $totalCount) {
            $columnChartModel->addColumn($tagName, $totalCount, '#' . substr(md5(rand()), 0, 6)); // Generate random color for each column
        }

        // Optionally customize chart properties
        $columnChartModel
            ->setTitle("Company Job Tags")

            ->setAnimated(true)
            ->setYAxisVisible(false)
            ->setDataLabelsEnabled(true)
            ->setLegendVisibility(true)
            ->setJsonConfig([
                'chart' => [
                    'height' => '300px',
                    'width' => '100%',
                ],
                'yaxis.tickAmount' => 1,
                'yaxis.labels.formatter' => '(val) => Math.floor(val)',
                'xaxis.labels.show' => false,
            ]);

        return $columnChartModel;
    }

    public function getHiredAndRejectedChart($pesoId)
    {
        // Retrieve job postings by company, filtered by peso_id and status
        $jobPostings = Job_Posting::where('company_id', $this->id)
            ->where('peso_id', $pesoId) // Filter by peso_id
            ->where('job_Status', 'COMPLETED') // Filter by completed job postings
            ->with('job_applicants') // Eager load job applicants
            ->get();

        // Initialize counts
        $hiredCount = 0;
        $rejectedCount = 0;

        // Count applicants based on status
        foreach ($jobPostings as $jobPosting) {
            foreach ($jobPosting->job_applicants as $applicant) {
                if ($applicant->applicant_Status === 'ACCEPTED') {
                    $hiredCount++;
                } elseif (in_array($applicant->applicant_Status, ['REJECTED', 'CANCELLED'])) {
                    $rejectedCount++;
                }
            }
        }

        // Generate the column chart model
        $columnChartModel = new ColumnChartModel();

        $columnChartModel->addColumn('HIRED', $hiredCount, '#008000');
        $columnChartModel->addColumn('REJECTED', $rejectedCount, '#FF0000');

        $columnChartModel
            ->setTitle("Job Applicants Hired")
            ->setAnimated(true)
            ->setYAxisVisible(false)
            ->setDataLabelsEnabled(true)
            ->setLegendVisibility(true)
            ->setJsonConfig([
                'chart' => [
                    'height' => '300px',
                    'width' => '100%',
                ],
                'yaxis.tickAmount' => 1,
                'yaxis.labels.formatter' => '(val) => Math.floor(val)',
                'xaxis.labels.show' => false,
            ]);

        // Add columns to the chart

        return $columnChartModel;
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

        $companyData = Company::findOrFail($this->id);

        $this->agreeBox = false;
        if ($companyData->user) {
            DB::beginTransaction();

            try {
                // Generate a new password
                $newPassword = $this->generatePassword();

                // Update the user's password (assuming 'password' is the column name)
                $companyData->user->password = Hash::make($newPassword);
                $companyData->user->save();

                DB::commit();

                $name = $companyData->business_Name;
                Mail::to($companyData->user->email)->queue(new AdminResetPasswordNotification($name, $newPassword));
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
        $joblist = null;
        $requirements = null;
        $partnership = null;
        $topTags = null;
        $totalHired = 0;

        $employer = Company::findOrFail($this->id);

        $user = Auth::user();

        if ($employer) {
            $joblist = $this->getJobs($user->peso_accounts->peso_id, $employer->company_id);
            $requirements = Requirements::with([
                'requirementPassed' => function ($query) use ($employer) {
                    $query->where('company_id', $employer->company_id); // Use `where` for filtering
                },
            ])
                ->where('requirement_Status', 1)
                ->where('requirement_Type', $this->empType)
                ->get();
            $topTags = $this->getTopJobTagsByCompany($employer->company_id);
            $partnership = Partnerships::where('company_id', $this->id)
                ->where('peso_id', $user->peso_accounts->peso_id)
                ->first();

            $totalHired = $employer->getTotalHiredApplicants($user->peso_accounts->peso_id);
            $countsAndChart = $this->getHiredAndRejectedChart($user->peso_accounts->peso_id);

        }

        $audits = Audit::where('user_id', $employer->user_id)
            ->latest()
            ->paginate(5);

        $formattedAudits = $audits->map(function ($audit) {
            return AuditFormatter::format($audit);
        });

        return view('livewire.admin.accounts.employer.employer-overview', compact('employer', 'joblist', 'requirements', 'topTags', 'partnership', 'totalHired', 'countsAndChart', 'audits', 'formattedAudits'));
    }
}
