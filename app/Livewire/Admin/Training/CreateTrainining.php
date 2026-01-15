<?php

namespace App\Livewire\Admin\Training;

use App\Mail\TrainingPostingNotification;
use App\Models\Employee;
use App\Models\Job_Industry;
use App\Models\Job_Positions;
use App\Models\Programs;
use App\Models\Program_Tags;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class CreateTrainining extends Component
{
    use WithFileUploads;

    public $progTitle, $progHost, $regDeadline, $progSlots, $progType = '', $progDate, $progTime, $progLoc, $progModality = '';

    public $descPost, $qualPost, $remPost;

    public $jobIndustryPost, $jobIndustryHidden;
    public $jobTags = [];

    public $searchHost;

    #[Validate]
    public $progImg;

    public function rules()
    {
        return [
            // BASIC INFORMATION
            'progImg' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // Validation rules
        ];
    }

    public function messages()
    {
        return [
            // Custom messages for validation rules
            'progImg.image' => 'The file must be an image.',
            'progImg.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'progImg.max' => 'The image may not be greater than 10 MB.',
        ];
    }

    public function getMatched($programInfo)
    {
        $programMunicipalityId = $programInfo->peso->municipality_id;
        $jobIndustryId = $programInfo->industry_id;
        $jobTagIds = $programInfo->program_tags->pluck('position_id');

        return Employee::whereHas('user', function ($query) {
            $query->where('userstatus', 1); // Ensure userstatus == 1
        })
            ->whereHas('barangay.municipality', function ($query) use ($programMunicipalityId) {
                $query->where('municipality_id', $programMunicipalityId);
            })
            ->whereHas('job_preference', function ($query) use ($jobTagIds) {
                $query->whereIn('position_id', $jobTagIds);
            })
            ->withCount(['job_preference as num_matched_tags' => function ($query) use ($jobTagIds) {
                $query->whereIn('position_id', $jobTagIds);
            }])
            ->withCount(['industry_preference as num_matched_industry' => function ($query) use ($jobIndustryId) {
                $query->where('industry_id', $jobIndustryId);
            }])
            ->orderByRaw('
                CASE
                    WHEN num_matched_industry > 0 AND num_matched_tags > 0 THEN 1
                    WHEN num_matched_industry > 0 AND num_matched_tags = 0 THEN 2
                    WHEN num_matched_industry = 0 AND num_matched_tags > 0 THEN 3
                    ELSE 4
                END
            ')
            ->orderByDesc('num_matched_tags')
            ->get();
    }

    public function validateInput()
    {

        $rules = [
            'progTitle' => 'required|string|max:255',
            'progHost' => 'required|string|max:255',
            'regDeadline' => 'required|date|after:tomorrow',
            'progSlots' => 'required|integer|nullable',
            'progType' => 'required|string',
            'progDate' => 'required_if:progType,PESO Hosted|date|after:tomorrow',
            'progTime' => 'required_if:progType,PESO Hosted|date_format:H:i',
            'progLoc' => 'required|string|max:255',
            'progModality' => 'required|string|max:255',
            'progImg' => 'required|image|mimes:jpg,jpeg,png|max:10240', // 10MB max
            'descPost' => 'required|string',
            'qualPost' => 'required|string',
            'remPost' => 'nullable|string', // Remarks are not required
            'jobIndustryPost' => 'required',
            'jobTags' => 'required',
        ];
        $messages = [
            'progTitle.required' => 'The program title is required.',
            'progTitle.string' => 'The program title must be a string.',
            'progTitle.max' => 'The program title may not be greater than 255 characters.',

            'progHost.required' => 'The program host is required.',
            'progHost.string' => 'The program host must be a string.',
            'progHost.max' => 'The program host may not be greater than 255 characters.',

            'regDeadline.required' => 'The registration deadline is required.',
            'regDeadline.date' => 'The registration deadline must be a valid date.',
            'regDeadline.after' => 'The registration deadline must be at least one day from now.',

            'progSlots.required' => 'The number of slots is required.',
            'progSlots.integer' => 'The number of slots must be an integer.',

            'progType.required' => 'The program type is required.',
            'progType.string' => 'The program type must be a string.',

            'progDate.required_if' => 'The program date is required if the program type is "PESO Hosted".',
            'progDate.date' => 'The program date must be a valid date.',
            'progDate.after' => 'The program date must be at least one day from now.',

            'progTime.required_if' => 'The program time is required if the program type is "PESO Hosted".',
            'progTime.date_format' => 'The program time must be in the format HH:MM.',

            'progLoc.required' => 'The program location is required.',
            'progLoc.string' => 'The program location must be a string.',
            'progLoc.max' => 'The program location may not be greater than 255 characters.',

            'progModality.required' => 'The program modality is required.',
            'progModality.string' => 'The program modality must be a string.',
            'progModality.max' => 'The program modality may not be greater than 255 characters.',

            'progImg.required' => 'The program image is required.',
            'progImg.image' => 'The program image must be an image file.',
            'progImg.mimes' => 'The program image must be a file of type: jpg, jpeg, png.',
            'progImg.max' => 'The program image may not be greater than 10MB.',

            'descPost.required' => 'The description is required.',
            'descPost.string' => 'The description must be a string.',

            'qualPost.required' => 'The qualifications is required.',
            'qualPost.string' => 'The qualifications must be a string.',

            'remPost.string' => 'The remarks must be a string.',

            'jobIndustryPost.required' => 'The industry is required.',

            'jobTags.required' => 'There must be at least 1 job tag.',
        ];

        $this->validate($rules, $messages);

        $this->dispatch('open-modal', 'confirm-modal');
    }

    public function saveProgram()
    {

        $peso_id = Auth::user()->peso_accounts->peso->peso_id;
        DB::beginTransaction();

        $data = [
            'program_Title' => $this->progTitle,
            'program_Modality' => $this->progModality,
            'program_Type' => $this->progType,
            'program_Host' => $this->progHost,
            'program_Slots' => ($this->progSlots === 0 || $this->progSlots === null) ? null : $this->progSlots,
            'program_Deadline' => $this->regDeadline,
            'program_Location' => $this->progLoc,
            'program_Description' => $this->descPost,
            'program_Qualification' => $this->qualPost,
            'program_Remarks' => $this->remPost,
            'program_Status' => 'ACTIVE',
            'industry_id' => $this->jobIndustryHidden,
            'peso_id' => $peso_id,
        ];

        // dd($data);

        if ($this->progType === 'PESO Hosted') {
            // Combine progDate and progTime into a single datetime
            if ($this->progDate && $this->progTime) {
                $programDatetime = Carbon::createFromFormat('Y-m-d H:i', $this->progDate . ' ' . $this->progTime);
                $data['program_Datetime'] = $programDatetime;
            }
        }

        if ($this->progImg) {
            $imgPath = $this->progImg->store('images/trainings', 'public');
            $data['program_pubmat'] = $imgPath;
        }

        try {
            $trainingProgram = Programs::create($data);

            if ($trainingProgram) {

                foreach ($this->jobTags as $jobTag) {
                    Program_Tags::create([
                        'program_id' => $trainingProgram->program_id,
                        'position_id' => $jobTag['position_id'],
                    ]);
                }
            }
            DB::commit();

            $matchingJobseekers = $this->getMatched($trainingProgram);

            if (!empty($matchingJobseekers)) {
                foreach ($matchingJobseekers as $employee) {
                    Mail::to($employee->user->email)->queue(new TrainingPostingNotification($employee, $trainingProgram));
                }
            }
            // SendMatchedEmails::dispatch($trainingProgram->program_id);

            $this->dispatch('close-modal', 'confirm-modal');
            $this->redirectRoute('admin-view-training', ['id' => $trainingProgram->program_id], navigate: true);
            toastr()->success('Training has been posted!');
        } catch (\Exception $e) {

            DB::rollback();
            if (isset($imgPath)) {
                Storage::disk('public')->delete($imgPath);
            }
            $this->dispatch('close-modal', 'confirm-modal');
            // Return error response or handle the error
            // toastr()->error('There was an error in posting the program.');
            toastr()->error($e->getMessage());
        }
    }


    public function forDropdownOptions()
    {
        $peso_id = Auth::user()->peso_accounts->peso->peso_id;

        $programHosts = Programs::where('peso_id', $peso_id)
            ->when(!empty($this->progHost), function ($query) {
                $query->where('program_Host', 'like', '%' . $this->progHost . '%');
            })
            ->select('program_Host as name')
            ->distinct();

        // Fetching business names
        $businessNames = Company::join('partnerships', 'partnerships.company_id', '=', 'company.company_id')
            ->where('partnerships.peso_id', $peso_id)
            ->where('partnerships.partnership_Status', 'APPROVED')
            ->when(!empty($this->progHost), function ($query) {
                $query->where('company.business_Name', 'like', '%' . $this->progHost . '%');
            })
            ->select('company.business_Name as name')
            ->groupBy('company.business_Name')
            ->distinct();

        // Combining the results
        $tHosts = $programHosts->union($businessNames)
            ->orderBy('name')
            ->get();

        return $tHosts;

    }


    public function selectHost($name)
    {
        // dd($name);
        $this->progHost = $name;
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

    #[On('positionSelect')]
    public function tagSelect($id)
    {
        // Check if the selected job position already exists in the $jobTags array
        if (collect($this->jobTags)->contains('position_id', $id)) {
            toastr()->warning('This job position is already selected.');
            return;
        }
        $totalTags = count($this->jobTags);

        if ($totalTags >= 15) {
            toastr()->error('You can only have a maximum of 15 tags.');
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

    public function render()
    {
        $hostssssssssss = $this->forDropdownOptions();
        // dd($hostssssssssss);

        return view('livewire.admin.training.create-trainining', compact('hostssssssssss'));
    }
}
