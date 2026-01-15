<?php

namespace App\Livewire\Admin\Training;

use App\Models\Job_Industry;
use App\Models\Job_Positions;
use App\Models\Programs;
use App\Models\Company;
use App\Models\Program_Tags;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class EditTraining extends Component
{

    use WithFileUploads;

    public $programData;

    public $progTitle, $progHost, $regDeadline, $progSlots, $progType = '', $progDate, $progTime, $progLoc, $progModality = '';

    public $descPost, $qualPost, $remPost;

    public $jobIndustryPost, $jobIndustryHidden;

    public $originalTags = [], $tagsToAdd = [], $tagsToRemove = [], $displayTags = [], $tagsToRestore = [];

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
    public function mount()
    {
        $this->programData = session()->get('programData');

        // dd($this->programData);
        $this->mountData($this->programData);

        $programtags = Program_Tags::where('program_id', $this->programData)->get();

        $this->originalTags = $programtags->map(function ($tags) {
            return [
                'program_tags_id' => $tags->program_tags_id, // Access the individual tag's program_tags_id
                'position_id' => $tags->position_id, // Access the individual tag's program_tags_id

                'position_Title' => strtoupper($tags->job_positions->position_Title), // Access the related job position's name
            ];
        })->toArray();

        // Initialize displayTags with the original tags for displaying them in the view
        $this->displayTags = $this->originalTags;

        // dd($this->originalTags);

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
            'progImg' => 'nullable|image|mimes:jpg,jpeg,png|max:10240', // 10MB max
            'descPost' => 'required|string',
            'qualPost' => 'required|string',
            'remPost' => 'nullable|string', // Remarks are not required
            'jobIndustryPost' => 'required',
            'displayTags' => 'required',

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

            'progImg.image' => 'The program image must be an image file.',
            'progImg.mimes' => 'The program image must be a file of type: jpg, jpeg, png.',
            'progImg.max' => 'The program image may not be greater than 10MB.',

            'descPost.required' => 'The description is required.',
            'descPost.string' => 'The description must be a string.',

            'qualPost.required' => 'The qualifications is required.',
            'qualPost.string' => 'The qualifications must be a string.',

            'remPost.string' => 'The remarks must be a string.',

            'jobIndustryPost.required' => 'The industry is required.',

            'displayTags.required' => 'There must be at least 1 program tags.',

        ];

        $this->validate($rules, $messages);

        $this->dispatch('open-modal', 'confirm-modal');
    }

    public function mountData($id)
    {
        $user = Auth::user();

        $programInfo = Programs::findOrFail($id);

        if ($user->peso_accounts->peso_id != $programInfo->peso_id) {
            return redirect()->back();
        }

        $this->progTitle = $programInfo->program_Title;
        $this->progHost = $programInfo->program_Host;
        $this->regDeadline = Carbon::parse($programInfo->program_Deadline)->format('Y-m-d');
        $this->progSlots = $programInfo->program_Slots;
        $this->progType = $programInfo->program_Type;
        $this->progDate = $programInfo->program_Datetime ? Carbon::parse($programInfo->program_Datetime)->format('Y-m-d') : '';
        $this->progTime = $programInfo->program_Datetime ? Carbon::parse($programInfo->program_Datetime)->format('H:i') : '';

        $this->progLoc = $programInfo->program_Location;
        $this->progModality = $programInfo->program_Modality;

        $this->descPost = $programInfo->program_Description;
        $this->qualPost = $programInfo->program_Qualification;
        $this->remPost = $programInfo->program_Remarks;

        $this->jobIndustryPost = $programInfo->job_industry->industry_Title;
        $this->jobIndustryHidden = $programInfo->industry_id;

        // dd($this->descPost);
    }

    public function cancelEdit()
    {
        $this->redirectRoute('admin-view-training', ['id' => $this->programData], navigate: true);
        // session()->forget('programData');

    }

    public function saveProgram()
    {
        $programInfo = Programs::findOrFail($this->programData);
        $programDatetime = null;
        $imgPath = null;

        if ($this->progImg) {
            $imgPath = $this->progImg->store('images/trainings', 'public');
        }

        DB::beginTransaction();

        try {
            // Delete old image if a new one is uploaded and there is an existing image
            if ($this->progImg && $programInfo->program_pubmat) {
                Storage::disk('public')->delete($programInfo->program_pubmat);
            }

            if ($this->progType === 'PESO Hosted') {
                // Combine progDate and progTime into a single datetime
                if ($this->progDate && $this->progTime) {
                    $programDatetime = Carbon::createFromFormat('Y-m-d H:i', $this->progDate . ' ' . $this->progTime);
                } else {
                    $programDatetime = null;
                }
            }

            // Update program model attributes
            $programInfo->program_Title = $this->progTitle;
            $programInfo->program_Host = $this->progHost;
            $programInfo->program_Deadline = $this->regDeadline;
            $programInfo->program_Type = $this->progType;
            $programInfo->program_Slots = ($this->progSlots === 0 || $this->progSlots === null) ? null : $this->progSlots;
            $programInfo->program_Datetime = $programDatetime;
            $programInfo->program_Location = $this->progLoc;
            $programInfo->program_Modality = $this->progModality;
            $programInfo->program_Description = $this->descPost;
            $programInfo->program_Qualification = $this->qualPost;
            $programInfo->program_Remarks = $this->remPost;
            $programInfo->industry_id = $this->jobIndustryHidden;

            // Set the new image path or retain the old one
            $programInfo->program_pubmat = $imgPath ?? $programInfo->program_pubmat;

            // Check if any changes were made to the programInfo or the tags
            $tagsChanged = $this->tagsToAdd || $this->tagsToRemove || $this->tagsToRestore;

            // dd( $this->tagsToAdd, $this->tagsToRemove , $this->tagsToRestore);

            if ($programInfo->isDirty() || $tagsChanged) {
                // Save program info first if dirty
                if ($programInfo->isDirty()) {
                    $programInfo->save();
                }

                // Handle tag changes
                // Add new tags
                foreach ($this->tagsToAdd as $tag) {
                    Program_Tags::create([
                        'program_id' => $programInfo->program_id,
                        'position_id' => $tag['position_id'],
                    ]);
                }

                // Remove tags
                foreach ($this->tagsToRemove as $tag) {
                    $programTag = Program_Tags::where('program_id', $programInfo->program_id)
                        ->where('program_tags_id', $tag['program_tags_id'])
                        ->first();

                    if ($programTag) {
                        $programTag->delete();
                    }
                }

                // Restore tags (assuming soft deletes)
                foreach ($this->tagsToRestore as $tag) {
                    $programTag = Program_Tags::withTrashed()
                        ->where('program_id', $programInfo->program_id)
                        ->where('program_tags_id', $tag['program_tags_id'])
                        ->first();

                    if ($programTag) {
                        $programTag->restore();
                    }
                }

                DB::commit();

                // Redirect and display success message
                $this->redirectRoute('admin-view-training', ['id' => $programInfo->program_id], navigate: true);
                toastr()->success('Program has been updated!');
            } else {
                DB::rollBack();
                toastr()->info('No changes detected.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());

            // Delete new image if it was uploaded and an error occurred
            if ($imgPath) {
                Storage::disk('public')->delete($imgPath);
            }

            toastr()->error('There was an error updating the program: ' . $e->getMessage());
        }

        $this->mount();
        $this->dispatch('close-modal', 'confirm-modal');
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
        $totalTags = count($this->displayTags);

        if ($totalTags >= 15) {
            toastr()->error('You can only have a maximum of 15 tags.');
            return;
        }

        $newTag = [
            'position_id' => $id,
            'position_Title' => strtoupper($jobPosition->position_Title),
        ];

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


    public function forDropdownOptions()
    {
        $peso_id = Auth::user()->peso_accounts->peso->peso_id;

        // $programHosts = DB::table('programs')
        //     ->join('peso', 'peso.peso_id', '=', 'programs.peso_id')
        //     ->where('programs.peso_id', $peso_id)
        //     ->when(!empty($this->progHost), function ($query) {
        //         $query->where('programs.program_Host', 'like', '%' . $this->progHost . '%');
        //     })
        //     ->select('programs.program_Host as name')
        //     ->distinct();

        // $businessNames = DB::table('company')
        //     ->join('partnerships', 'partnerships.company_id', '=', 'company.company_id')
        //     ->join('peso', 'peso.peso_id', '=', 'partnerships.peso_id')
        //     ->where('partnerships.peso_id', $peso_id)
        //     ->where('partnerships.partnership_Status', 'APPROVED')
        //     ->when(!empty($this->progHost), function ($query) {
        //         $query->where('company.business_Name', 'like', '%' . $this->progHost . '%');
        //     })
        //     ->select('company.business_Name as name')
        //     ->groupBy('company.business_Name') // Use groupBy for distinct results
        //     ->distinct();
        //     $tHosts = $programHosts->union($businessNames)
        //         ->orderBy('name') 
        //         ->get();


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
        $this->progHost = $name;
    }

    public function render()
    {
        $programInfo = Programs::findOrFail($this->programData);
        $hostssssssssss = $this->forDropdownOptions();


        // dd($this->programData);
        return view('livewire.admin.training.edit-training', compact('programInfo', 'hostssssssssss'));
    }
}
