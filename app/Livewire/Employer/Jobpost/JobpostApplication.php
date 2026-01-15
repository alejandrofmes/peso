<?php

namespace App\Livewire\Employer\Jobpost;

use App\Mail\JobPostApplicationNotification;
use App\Models\Barangay;
use App\Models\Job_Industry;
use App\Models\Job_Positions;
use App\Models\Job_Posting;
use App\Models\Job_Tags;
use App\Models\Municipality;
use App\Models\PESO;
use App\Models\Requirements;
use App\Models\Requirements_Passed;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class JobpostApplication extends Component
{

    use WithFileUploads;

    public $jobTitlePost;
    public $jobIndustryPost, $jobIndustryHidden;
    public $minWagePost;
    public $maxWagePost;
    public $eduPost = '';
    public $jtypePost = '';
    public $wAddPost;
    public $barPost, $barHidden;
    public $pesoPost = '';
    public $disabilityPost;
    public $durationPost;
    public $slotsPost;
    public $jobTags = [];
    public $descPost;
    public $qualPost;
    public $remPost;

    public $mun, $prov;
    public $agreePost;

    public $currentSlide = 1;

    public function prevSection($id)
    {
        $this->currentSlide = $id;
    }

    public function nextSection($id)
    {

        if ($id == 2) {
            $rules = [
                'jobTitlePost' => ['required', 'string'],
                'jobIndustryPost' => ['required'],
                'minWagePost' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'min:1'],
                'maxWagePost' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'min:1', 'gte:minWagePost', function ($attribute, $value, $fail) {
                    if ($value && !$this->minWagePost) {
                        $fail('Minimum wage is required when maximum wage is provided.');
                    }
                }],
                'eduPost' => ['required'],
                'jtypePost' => ['required'],
                'wAddPost' => ['required', 'string'],
                'barPost' => ['required'],
                'pesoPost' => ['required'],
                'disabilityPost' => ['required'],
                'durationPost' => ['required', 'date', 'after_or_equal:' . Carbon::now()->addWeek()->format('Y-m-d'), 'before_or_equal:' . Carbon::now()->addMonth()->format('Y-m-d')],
                'slotsPost' => ['required', 'numeric', 'min:1'],
                'descPost' => ['required', 'string'],
                'qualPost' => ['required', 'string'],
                'remPost' => ['nullable', 'string'],
                'jobTags' => ['required', 'array', 'min:1'],
            ];

            $messages = [
                'jobTitlePost.required' => 'The job title is required.',
                'jobIndustryPost.required' => 'Please select at least one industry.',
                'minWagePost.required' => 'Minimum wage is required.',
                'minWagePost.regex' => 'Minimum wage must be a valid number with up to two decimal places.',
                'minWagePost.min' => 'Minimum wage must be at least 1.',
                'maxWagePost.required' => 'Maximum wage is required.',
                'maxWagePost.regex' => 'Maximum wage must be a valid number with up to two decimal places.',
                'maxWagePost.min' => 'Maximum wage must be at least 1.',
                'maxWagePost.gte' => 'Maximum wage must be greater than or equal to minimum wage.',
                'eduPost.required' => 'Please select required education level.',
                'jtypePost.required' => 'Please select job type.',
                'wAddPost.required' => 'Work address is required.',
                'barPost.required' => 'Please select barangay.',
                'pesoPost.required' => 'PESO municipality is required.',
                'disabilityPost.required' => 'Please select an option.',
                'durationPost.required' => 'Job duration is required.',
                'durationPost.date' => 'Job duration must be a valid date.',
                'durationPost.after_or_equal' => 'The job posting must last at least 1 week in the future.',
                'durationPost.before_or_equal' => 'The job posting duration must not exceed 1 month from today.',
                'slotsPost.required' => 'Number of slots is required.',
                'slotsPost.numeric' => 'Slots must be a number.',
                'slotsPost.min' => 'Minimum number of slots is 1.',
                'descPost.required' => 'Job description is required.',
                'qualPost.required' => 'Qualifications are required.',
                'jobTags.required' => 'Please select at least one job tag.',
                'jobTags.array' => 'Job tags must be an array.',
                'jobTags.min' => 'Please select at least one job tag.',
            ];

            $this->validate($rules, $messages);

            $this->currentSlide++;
        }

    }

    public function createApplication()
    {
        // Validate the input
        $this->validate([
            'agreePost' => ['required'],
        ], [
            'agreePost.required' => 'You must agree with the terms and conditions before proceeding.',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Retrieve the authenticated user and company ID
            $user = Auth::user();
            $companyId = $user->company->company_id;

            // Get the current date and date one year ago
            $currentDate = now();
            $oneYearAgo = $currentDate->copy()->subYear();

            // Fetch all active requirements
            $activeRequirements = Requirements::where('requirement_Status', 1)
                ->where('requirement_Type', $user->company->employer_Type)->get();

            foreach ($activeRequirements as $requirement) {
                $requirementPassed = Requirements_Passed::where('requirement_id', $requirement->requirement_id)
                    ->where('company_id', $companyId)
                    ->where('updated_at', '>=', $oneYearAgo)
                    ->first();

                if (!$requirementPassed) {
                    // Display a toast error and rollback the transaction
                    toastr()->error("The company has either not completed all required submissions or has not updated them within the last year.");
                    // Rollback the transaction and return early
                    DB::rollBack();

                    return;
                }
            }

            // Create a new job posting
            $jobposting = Job_Posting::create([
                'company_id' => $companyId,
                'industry_id' => $this->jobIndustryHidden,
                'job_Title' => $this->jobTitlePost,
                'job_Description' => $this->descPost,
                'job_Qualifications' => $this->qualPost,
                'job_Remarks' => $this->remPost,
                'job_MinWage' => $this->minWagePost ? $this->minWagePost : null,
                'job_MaxWage' => $this->maxWagePost ? $this->maxWagePost : null,
                'job_Type' => $this->jtypePost,
                'job_Edu' => $this->eduPost,
                'job_Disability' => $this->disabilityPost,
                'job_Slots' => $this->slotsPost,
                'job_Address' => $this->wAddPost,
                'barangay_id' => $this->barHidden,
                'job_Duration' => $this->durationPost,
                'job_Status' => 'PENDING',
                'peso_id' => $this->pesoPost,
            ]);

            // Check if job posting was created successfully
            if ($jobposting) {
                // Create job tags
                foreach ($this->jobTags as $jobTag) {
                    Job_Tags::create([
                        'job_id' => $jobposting->job_id,
                        'position_id' => $jobTag['position_id'],
                    ]);
                }

                // Commit the transaction
                DB::commit();

                // Redirect to the job posting show route
                Mail::to($jobposting->company->user->email)->queue(new JobPostApplicationNotification($jobposting));

                toastr()->success('You have successfully submitted an application!');
                $this->redirectRoute('jobpost.show', ['id' => $jobposting->job_id], navigate: true);
            }
        } catch (\Exception $e) {

            DB::rollBack();
            dd($e->getMessage());
            toastr()->error('Application Failed. Please check your input.');
        } catch (\Exception $e) {
            // Roll back the transaction in case of general exceptions
            DB::rollBack();
            dd($e->getMessage());

            // Handle other errors (e.g., log the error, display a generic error message)
            toastr()->error('An unexpected error occurred. Please try again.');
        }
    }

    #[On('positionSelect')]
    public function tagSelect($id)
    {
        // Check if the selected job position already exists in the $jobTags array
        if (collect($this->jobTags)->contains('position_id', $id)) {
            toastr()->warning('This job tags is already selected.');
            return;
        }
        if (count($this->jobTags) >= 15) {
            toastr()->error('You can only select up to 15 job tags.');
            return;
        }

        // If the job position does not exist in the array, add it
        $jobposition = Job_Positions::find($id);

        if ($jobposition) {
            $this->jobTags[] = [
                'position_id' => $jobposition->position_id,
                'position_Title' => $jobposition->position_Title,
            ];
            $this->dispatch('close-modal', 'job-position-modal');
        } else {
            toastr()->error('Could not fetch data');
            $this->dispatch('close-modal', 'job-position-modal');
        }
    }

    public function removeTag($positionId)
    {
        // Find the index of the element with the given position_id
        $index = array_search($positionId, array_column($this->jobTags, 'position_id'));

        // If the element exists in the array, remove it
        if ($index !== false) {
            unset($this->jobTags[$index]);
            // Reindex the array to maintain sequential keys
            $this->jobTags = array_values($this->jobTags);
        }
    }

    #[On('industrySelect')]
    public function industrySelect($id)
    {
        $industry = Job_Industry::find($id);

        if ($industry) {
            $this->jobIndustryHidden = $industry->industry_id;
            $this->jobIndustryPost = $industry->industry_Title;

        } else {
            toastr()->error('Could not fetch data');
        }

    }

    #[On('barSelect')]
    public function barSelect($id)
    {
        $barangay = Barangay::with('municipality.province')->find($id);

        if ($barangay) {
            $this->barHidden = $barangay->barangay_id;
            $this->barPost = $barangay->barangay_Name;
            $this->mun = $barangay->municipality->municipality_Name;
            $this->prov = $barangay->municipality->province->province_Name;

        } else {
            toastr()->error('Could not fetch data');
        }

    }

    public function render()
    {

        $user = Auth::user();

        $pesoBranches = PESO::whereHas('partnerships', function ($query) use ($user) {
            $query->where('partnership_Status', 'APPROVED')
                ->where('company_id', $user->company->company_id);
        })->get();

        return view('livewire.employer.jobpost.jobpost-application', [
            'pesoBranches' => $pesoBranches,
        ]);
    }
}
