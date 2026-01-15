<?php

namespace App\Livewire\Admin\JobPosting\Applicants;

use App\Mail\NewApplicantNotification;
use App\Mail\RecommendationNotification;
use App\Models\Barangay;
use App\Models\Education;
use App\Models\Employee;
use App\Models\Industry_preference;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use App\Models\Job_Preference;
use App\Models\Work_Exp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class ApplicantOverview extends Component
{

    use WithFileUploads;

    public $id;
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

    public $recommendationRemarks, $rejectRemarks, $recLetter;

    public function mount()
    {
        $user = Auth::user();

        $applicant = Job_Applicants::findOrFail($this->id);

        if ($applicant) {
            if ($user->peso_accounts->peso_id != $applicant->job_posting->peso_id) {
                return $this->redirectRoute('dashboard');

            }
        } else {
            return $this->redirectRoute('dashboard');

        }
    }

    public function viewFile($id, $fileToView)
    {

        if ($fileToView === 3) {

            $this->dispatch('viewFile', [
                'url' => route('view.recommendation'),
                'app_id' => $id,
            ]);

        } else {

            $this->dispatch('viewFile', [
                'url' => route('view.resume'),
                'emp_id' => $id,
                'resume_type' => $fileToView,
            ]);
        }

    }

    public function updateApplicant($action, $modal)
    {
        $pesoAdmin = Auth::user();

        // Validate the action
        if (!in_array($action, ['RECOMMENDED', 'REJECT'])) {
            toastr()->error('Invalid action specified!');
            return;
        }

        // Retrieve the job applicant instance
        $applicant = Job_Applicants::find($this->id);

        if (!$applicant) {
            toastr()->error('Applicant not found!');
            return;
        }

        $validationRules = [];
        $validationMessages = [];

        if ($action === 'RECOMMENDED') {
            $validationRules = [
                'recommendationRemarks' => ['required', 'string', 'min:10'],
                'recLetter' => [
                    'required',
                    'file',
                    'mimes:pdf',
                    'max:15360', // 5MB
                ],
            ];
            $validationMessages = [
                'recLetter.required' => 'The recommendation letter is required.',
                'recLetter.file' => 'The recommendation letter must be a file.',
                'recLetter.mimes' => 'The recommendation letter must be a PDF file.',
                'recLetter.max' => 'The recommendation letter may not be greater than 15MB in size.',
            ];
        } elseif ($action === 'REJECT') {
            $validationRules = [
                'rejectRemarks' => ['required', 'string', 'min:10'],
            ];
        }

        // Validate the input based on the action
        $this->validate($validationRules, $validationMessages);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Determine the validation rules and messages based on the action

            // If action is 'RECOMMENDED', check if the file upload is successful
            if ($action === 'RECOMMENDED') {
                // Attempt to store the recommendation letter
                $filePath = $this->recLetter->store('peso/recommendation', 'public');

                if (!$filePath) {
                    // If the file upload fails, show an error and rollback
                    DB::rollBack();
                    toastr()->error('Failed to upload the recommendation letter.');
                    return;
                }

                // Store the file path in the applicant record
                $applicant->peso_Letter = $filePath;
            }

            // Update the job applicant based on the action
            $applicant->peso_Status = $action;
            $applicant->peso_Remarks = $action === 'RECOMMENDED' ? $this->recommendationRemarks : $this->rejectRemarks;
            $applicant->applicant_Notif = 1;
            $applicant->responded_at = now();
            $applicant->peso_accounts_id = $pesoAdmin->peso_accounts->peso_accounts_id;

            // Save the changes
            $applicant->save();

            // Commit the transaction
            DB::commit();

            // Send notification mail after transaction success
            Mail::to($applicant->employee->user->email)->queue(new RecommendationNotification($applicant));
            Mail::to($applicant->job_posting->company->user->email)->queue(new NewApplicantNotification($applicant));

            toastr()->success('Applicant updated successfully!');
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();
            toastr()->error('There was an error updating the applicant!');
            Log::error('Error updating applicant: ' . $e->getMessage());
        }

        // Close the modal after updating
        $this->closeModal($modal);
    }

    public function closeModal($modal)
    {
        $this->resetValidation();
        $this->reset('recommendationRemarks', 'rejectRemarks', 'recLetter');
        $this->dispatch('close-modal', $modal . '-modal');
    }

    private function checkJobseekerMunicipality($applicant)
    {
        if ($applicant->employee->barangay->municipality_id == $applicant->job_posting->peso->municipality_id) {
            return true;
        } else {
            return false;
        }

    }

    private function checkIfJobSeekerMatches($applicant)
    {
        // Get the highest education level of the employee
        $highestEducationLevel = Education::where('employee_id', $applicant->employee->employee_id)
            ->max('edu_level');

        // Get the employee's municipality ID via their barangay
        $employeeMunicipalityId = Barangay::where('barangay_id', $applicant->employee->barangay_id)
            ->value('municipality_id');

        // Get the employee's job preferences (array of position_id)
        $employeeJobPreferences = Job_Preference::where('employee_id', $applicant->employee->employee_id)
            ->pluck('position_id')
            ->toArray();

        // Get the employee's industry preferences (array of industry_id)
        $employeeIndustryPreference = Industry_Preference::where('employee_id', $applicant->employee->employee_id)
            ->pluck('industry_id')
            ->toArray();

        // Query to check if the specific job posting matches the employee
        return Job_Posting::where('job_id', $applicant->job_id)
        // ->where('job_Status', 'ACTIVE')
        // ->whereHas('peso.municipality', function ($query) use ($employeeMunicipalityId) {
        //     $query->where('municipality_id', $employeeMunicipalityId);
        // })
            ->where('job_Edu', '<=', $highestEducationLevel)
            ->where(function ($query) use ($employeeJobPreferences, $employeeIndustryPreference) {
                $query->where(function ($subQuery) use ($employeeJobPreferences) {
                    $subQuery->whereHas('job_tags', function ($query) use ($employeeJobPreferences) {
                        $query->whereIn('position_id', $employeeJobPreferences);
                    });
                })
                    ->orWhere(function ($subQuery) use ($employeeIndustryPreference) {
                        $subQuery->whereIn('industry_id', $employeeIndustryPreference);
                    });
            })
            ->exists();
    }

    public function render()
    {
        $user = Auth::user();

        $applicant = Job_Applicants::findOrFail($this->id);

        if ($user->peso_accounts->peso_id != $applicant->job_posting->peso_id) {
            return redirect()->route('admin-joblist');
        }

        $maxEduLevel = $applicant->employee->education->max('edu_Level');

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

        $totalExperience = Work_Exp::getTotalExperience($applicant->employee_id);

        $isMatch = $this->checkIfJobSeekerMatches($applicant);

        $isResident = $this->checkJobseekerMunicipality($applicant);

        return view('livewire.admin.job-posting.applicants.applicant-overview', compact('applicant', 'isMatch', 'attainment', 'totalExperience', 'isResident'));
    }

}
