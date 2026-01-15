<?php

namespace App\Livewire\Public;

use App\Mail\NewJobApplicationNotification;
use App\Models\Experimental_Features;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class JobpostView extends Component
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
    public $jobTypes = [
        '0' => 'None',
        '1' => 'Full Time',
        '2' => 'Contractual',
        '3' => 'Part Time',
        '4' => 'Project-Based',
        '5' => 'Internship/OJT',
        '6' => 'Work From Home',
    ];

    public $option;
    public $resume;

    public function mount()
    {
        $JobPost = Job_Posting::find($this->id);
        if ($JobPost) {
            if (Auth::check() && Auth::user()->usertype <= 5 && $JobPost->job_Status == 'PENDING') {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('dashboard');

        }

    }

    public function applyValidate()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Open the login modal if the user is not logged in
            $this->dispatch('open-modal', 'login-modal');
            return; // Exit the method
        }

        // Get the job posting and user
        $jobpost = Job_Posting::find($this->id); // Use find() for a single record
        $user = Auth::user();
        $userMunicipalityId = $user->employee->barangay->municipality_id;

        if (!$jobpost) {
            // Handle the case where the job posting is not found
            toastr()->error('Job posting not found.');
            return;
        }

        $jobpostMunicipalityId = $jobpost->peso->municipality_id;

        $crossJobFeature = Experimental_Features::find(1);

        // Determine whether cross-municipality applications are enabled
        $isCrossJobEnabled = $crossJobFeature && $crossJobFeature->feature_Status === 'enabled';

        // Check if the user is eligible to apply for the job posting
        if ($isCrossJobEnabled || $userMunicipalityId == $jobpostMunicipalityId) {
            // Open the apply modal
            $this->dispatch('open-modal', 'apply-modal');
        } else {
            // Show an error if the user's municipality does not match
            toastr()->error('This job posting is only available to ' . $jobpost->peso->municipality->municipality_Name . ' residents.');
        }

    }

    public function updateOption($option)
    {
        $this->option = $option;

    }

    public function apply()
    {
        $this->validate([
            'option' => ['required'],
        ], [
            'option.required' => 'You must choose a resume option.',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Start a database transaction
        DB::beginTransaction();

        try {
            // If the user selected option 2 and doesn't have a resume already
            if ($this->option == 1 && empty($user->employee->resume)) {
                // Validate the resume upload
                $this->validate([
                    'resume' => ['required', 'file', 'mimes:pdf', 'max:5120'], // 'max' is in kilobytes (5MB = 5120KB)
                ], [
                    'resume.required' => 'The resume file is required.',
                    'resume.file' => 'The resume must be a file.',
                    'resume.mimes' => 'The resume must be a PDF file.',
                    'resume.max' => 'The resume may not be greater than 5MB in size.',
                ]);

                // Store the resume file
                $resumePath = $this->resume->store('resumes', 'public');

                // Update the user's employee record with the resume path
                $user->employee->update([
                    'resume' => $resumePath,
                ]);
            }

            // Create a new job applicant record
            $application = Job_Applicants::create([
                'employee_id' => $user->employee->employee_id,
                'job_id' => $this->id,
                'applicant_Resume' => $this->option,
                'applicant_Status' => "PENDING",
                'peso_Status' => "PENDING",
            ]);

            // Send email notification
            if ($application) {
                Mail::to($application->employee->user->email)->queue(new NewJobApplicationNotification($application));
            }

            // Commit the transaction
            DB::commit();

            $this->close();
            toastr()->success('Application submitted successfully.');

        } catch (\Exception $e) {
            // Rollback the transaction if there's an error
            DB::rollBack();
            toastr()->error('There was an error in the application: ' . $e->getMessage());
        }
    }

    public function close()
    {
        $this->reset('resume', 'option');
        $this->dispatch('close-modal', 'apply-modal');
    }

    public function render()
    {

        $isApplied = false;
        $JobPost = Job_Posting::withCount('hiredApplicants')->find($this->id);

        if ($JobPost) {
            $JobPost->slotsLeft = $JobPost->job_Slots - $JobPost->hired_applicants_count;
        }

        if (!$JobPost) {
            return redirect()->route('dashboard');
        }

        if (Auth::check()) {

            if (Auth::user()->usertype === 4) {
                $isApplied = Job_Applicants::where('job_id', $this->id)
                    ->where('employee_id', Auth::user()->employee->employee_id)
                    ->exists();

            }
        }

        return view('livewire.public.jobpost-view', compact('JobPost', 'isApplied'));
    }
}
