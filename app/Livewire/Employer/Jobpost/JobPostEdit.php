<?php

namespace App\Livewire\Employer\Jobpost;

use App\Models\Job_Positions;
use App\Models\Job_Posting;
use App\Models\Job_Tags;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class JobPostEdit extends Component
{

    public $jobpostData;

    public $originalTags = [], $tagsToAdd = [], $tagsToRemove = [], $displayTags = [], $tagsToRestore = [];

    public $jobTitlePost;
    public $jobIndustryPost, $jobIndustryHidden;
    public $minWagePost, $maxWagePost, $eduPost = '', $jtypePost = '', $wAddPost, $barPost, $barHidden, $pesoPost = '', $pesoTitle, $disabilityPost, $durationPost, $slotsPost, $descPost, $qualPost, $remPost, $mun, $prov;

    public function mount()
    {
        $this->jobpostData = session()->get('jobpostData');

        $this->mountData($this->jobpostData);

        $programtags = Job_Tags::where('job_id', $this->jobpostData)->get();

        $this->originalTags = $programtags->map(function ($tags) {
            return [
                'job_tags_id' => $tags->job_tags_id, // Access the individual tag's job_tags_id
                'position_id' => $tags->position_id, // Access the individual tag's job_tags_id

                'position_Title' => strtoupper($tags->job_positions->position_Title), // Access the related job position's name
            ];
        })->toArray();

        // Initialize displayTags with the original tags for displaying them in the view
        $this->displayTags = $this->originalTags;

    }

    public function mountData($id)
    {
        $jobPost = Job_Posting::findOrFail($id);

        $this->jobTitlePost = $jobPost->job_Title;
        $this->jobIndustryPost = $jobPost->job_industry->industry_Title;
        $this->minWagePost = $jobPost->job_MinWage;
        $this->maxWagePost = $jobPost->job_MaxWage;
        $this->eduPost = $jobPost->job_Edu;
        $this->jtypePost = $jobPost->job_Type;
        $this->disabilityPost = $jobPost->job_Disability;

        $this->pesoPost = $jobPost->peso_id;
        $this->pesoTitle = $jobPost->peso->municipality->municipality_Name;

        $this->durationPost = Carbon::parse($jobPost->job_Duration)->format('Y-m-d');
        $this->slotsPost = $jobPost->job_Slots;

        $this->descPost = $jobPost->job_Description;
        $this->qualPost = $jobPost->job_Qualifications;
        $this->remPost = $jobPost->job_Remarks;

        $this->wAddPost = $jobPost->job_Address;
        $this->barPost = $jobPost->barangay->barangay_Name;
        $this->mun = $jobPost->barangay->municipality->municipality_Name;
        $this->prov = $jobPost->barangay->municipality->province->province_Name;

    }

    public function validateInput()
    {

        $rules = [
            'jobTitlePost' => ['required', 'string'],
            'minWagePost' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/', 'min:1'],
            'maxWagePost' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/', 'min:1', 'gte:minWagePost', function ($attribute, $value, $fail) {
                if ($value && !$this->minWagePost) {
                    $fail('Minimum wage is required when maximum wage is provided.');
                }
            }],
            'descPost' => ['required', 'string'],
            'qualPost' => ['required', 'string'],
            'remPost' => ['nullable', 'string'],
            'displayTags' => ['required', 'array', 'min:1'],
            'disabilityPost' => ['required'],
        ];

        $messages = [
            'jobTitlePost.required' => 'The job title is required.',
            'jobIndustryPost.required' => 'Please select at least one industry.',
            // 'minWagePost.required' => 'Minimum wage is required.',
            'minWagePost.regex' => 'Minimum wage must be a valid number with up to two decimal places.',
            'minWagePost.min' => 'Minimum wage must be at least 1.',
            // 'maxWagePost.required' => 'Maximum wage is required.',
            'maxWagePost.regex' => 'Maximum wage must be a valid number with up to two decimal places.',
            'maxWagePost.min' => 'Maximum wage must be at least 1.',
            'maxWagePost.gte' => 'Maximum wage must be greater than or equal to minimum wage.',
            'descPost.required' => 'Job description is required.',
            'qualPost.required' => 'Qualifications are required.',
            'displayTags.required' => 'Please select at least one job tag.',
            'displayTags.array' => 'Job tags must be an array.',
            'displayTags.min' => 'Please select at least one job tag.',
            'disabilityPost.required' => 'Please select an option.',

        ];

        $this->validate($rules, $messages);

        $this->dispatch('open-modal', 'confirm-modal');

    }
    public function saveJobPost()
    {
        $jobpostInfo = Job_Posting::findOrFail($this->jobpostData);

        DB::beginTransaction();

        try {

            $jobpostInfo->job_Title = $this->jobTitlePost;
            $jobpostInfo->job_MinWage = $this->minWagePost ? $this->minWagePost : null;
            $jobpostInfo->job_MaxWage = $this->maxWagePost ? $this->maxWagePost : null;
            $jobpostInfo->job_Description = $this->descPost;
            $jobpostInfo->job_Qualifications = $this->qualPost;
            $jobpostInfo->job_Remarks = $this->remPost;
            $jobpostInfo->job_Disability = $this->disabilityPost;

            $tagsChanged = $this->tagsToAdd || $this->tagsToRemove || $this->tagsToRestore;
            if ($jobpostInfo->isDirty() || $tagsChanged) {
                // Save program info first if dirty
                if ($jobpostInfo->isDirty()) {
                    $jobpostInfo->save();
                }

                // Handle tag changes
                // Add new tags
                foreach ($this->tagsToAdd as $tag) {
                    Job_Tags::create([
                        'job_id' => $jobpostInfo->job_id,
                        'position_id' => $tag['position_id'],
                    ]);
                }

                // Remove tags
                foreach ($this->tagsToRemove as $tag) {
                    $programTag = Job_Tags::where('job_id', $jobpostInfo->job_id)
                        ->where('job_tags_id', $tag['job_tags_id'])
                        ->first();

                    if ($programTag) {
                        $programTag->delete();
                    }
                }

                // Restore tags (assuming soft deletes)
                foreach ($this->tagsToRestore as $tag) {
                    $programTag = Job_Tags::withTrashed()
                        ->where('job_id', $jobpostInfo->job_id)
                        ->where('job_tags_id', $tag['job_tags_id'])
                        ->first();

                    if ($programTag) {
                        $programTag->restore();
                    }
                }

                DB::commit();

                // Redirect and display success message
                $this->redirectRoute('jobpost.details', ['id' => $jobpostInfo->job_id], navigate: true);

                toastr()->success('Job post application has been updated!');
            } else {
                DB::rollBack();
                $this->dispatch('close-modal', 'confirm-modal');
                toastr()->info('No changes detected.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());

            // Delete new image if it was uploaded and an error occurred

            toastr()->error('There was an error updating the program: ' . $e->getMessage());
        }
    }

    #[On('positionSelect')]
    public function addTag($id)
    {
        // Fetch the position name from the database
        $jobPosition = Job_Positions::find($id);

        if (!$jobPosition) {
            toastr()->error('Job position not found.');
            return;
        }

        $newTag = [
            'position_id' => $id,
            'position_Title' => strtoupper($jobPosition->position_Title),
        ];

        $totalTags = count($this->displayTags);

        if ($totalTags >= 15) {
            toastr()->error('You can only have a maximum of 15 tags.');
            return;
        }

        // Check if the tag is in tagsToRestore
        if (collect($this->tagsToRestore)->contains('position_id', $id)) {
            // Move it to originalTags and displayTags
            $this->tagsToRestore = collect($this->tagsToRestore)->reject(function ($tag) use ($id) {
                return $tag['position_id'] === $id;
            })->toArray();

            // Add to originalTags if not already present
            if (!collect($this->originalTags)->contains('position_id', $id)) {
                $this->originalTags[] = $newTag;
            }

            $this->displayTags[] = $newTag;
            toastr()->success('Program tag has been added.');

            return;
        }

        // Check if the tag is in tagsToRemove
        if (collect($this->tagsToRemove)->contains('position_id', $id)) {
            // Remove from tagsToRemove and add to originalTags and displayTags
            $this->tagsToRemove = collect($this->tagsToRemove)->reject(function ($tag) use ($id) {
                return $tag['position_id'] === $id;
            })->toArray();

            // Add to originalTags if not already present
            if (!collect($this->originalTags)->contains('position_id', $id)) {
                $this->originalTags[] = $newTag;
            }

            $this->displayTags[] = $newTag;
            toastr()->success('Program tag has been added.');

            return;
        }

        // Check if the tag is already in originalTags
        if (collect($this->originalTags)->contains('position_id', $id)) {
            toastr()->warning('This job tag is already selected.');
            return;
        }

        // Check if the tag is already in tagsToAdd
        if (collect($this->tagsToAdd)->contains('position_id', $id)) {
            toastr()->warning('This job tag is already added.');
            return;
        }

        // Add to tagsToAdd and displayTags
        $this->tagsToAdd[] = $newTag;
        $this->displayTags[] = $newTag;
        toastr()->success('Program tag has been added.');

    }

    public function removeTag($tagId)
    {
        // Check if the tag is in originalTags
        if (collect($this->originalTags)->contains('position_id', $tagId)) {
            // Move it to tagsToRemove and remove from displayTags
            $this->tagsToRemove[] = collect($this->originalTags)->firstWhere('position_id', $tagId);

            // Update originalTags
            $this->originalTags = collect($this->originalTags)->reject(function ($tag) use ($tagId) {
                return $tag['position_id'] === $tagId;
            })->toArray();

            $this->displayTags = collect($this->displayTags)->reject(function ($tag) use ($tagId) {
                return $tag['position_id'] === $tagId;
            })->toArray();
        } else {
            // Tag was added in this session, so just remove it from tagsToAdd
            $this->tagsToAdd = collect($this->tagsToAdd)->reject(function ($tag) use ($tagId) {
                return $tag['position_id'] === $tagId;
            })->toArray();
        }

        // Remove from tagsToRestore if present
        $this->tagsToRestore = collect($this->tagsToRestore)->reject(function ($tag) use ($tagId) {
            return $tag['position_id'] === $tagId;
        })->toArray();
    }

    public function render()
    {
        return view('livewire.employer.jobpost.job-post-edit');
    }
}
