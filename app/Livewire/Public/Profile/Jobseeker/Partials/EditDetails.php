<?php

namespace App\Livewire\Public\Profile\Jobseeker\Partials;

use App\Models\Barangay;
use App\Models\Disability;
use App\Models\Eligibility;
use App\Models\Eligibility_Type;
use App\Models\Employee;
use App\Models\Industry_preference;
use App\Models\Job_Applicants;
use App\Models\Job_Industry;
use App\Models\Job_Positions;
use App\Models\Job_Preference;
use App\Models\Language;
use App\Models\License;
use App\Models\License_Type;
use App\Models\Skills;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class EditDetails extends Component
{
    use WithFileUploads, WithPagination, WithoutUrlPagination;

    public $empID;
    public $searchLang, $searchEli, $searchLic, $searchEl, $searchLi;

    // BASIC INFORMATION

    #[Validate]
    public $pimg;

    public $fname, $mname, $lname, $suffix, $birthdate, $gender = 0, $civilstatus = 0, $religion = 0,
    $pnumber, $tinnum, $height, $address, $empStatus = "", $empDesc = "", $ofw, $fourp, $fourpID, $privacy;

    public $barangayID, $mun, $prov, $bar;
    public $selectDisability = "", $otherDisability = "";
    public $jobpreference, $industrypreference;
    public $skills;

    // LANGUAGE
    public $langID;
    public $selectedLanguage = "", $otherLanguage;
    public $read, $write, $speak, $understand;

    // ELIGIBILITY
    public $eliID;
    public $eliTypeID;
    public $eli_Name = 'Select Eligibility', $eli_Date;

    //LICENSE
    public $licName = 'Select License', $licValidity;
    public $licID, $licTypeID;

    // DISABILITIES
    public $originalDisabilities = [], $disabilitiesToAdd = [], $disabilitiesToRemove = [], $displayDisabilities = [], $disabilitiesToRestore = [];

    public $originalSkills = [], $skillsToAdd = [], $skillsToRemove = [], $displaySkills = [], $skillsToRestore = [];

    public $empDescriptions = [];

    // RESUME
    public $newResume;

    public $deleteEli, $deleteLic, $deleteLang;

    //RULES
    public function rules()
    {
        return [
            // BASIC INFORMATION
            'pimg' => 'nullable|image|mimes:jpeg,png,jpg',
        ];
    }

    public function messages()
    {
        return [
            'pimg.image' => 'The file must be an image.',
            'pimg.mimes' => 'The image must be of type: jpeg, png, jpg.',
            // 'pimg.max' => 'The image size must not exceed 5 MB.',
        ];
    }

    public function mount()
    {
        $user = Auth::user();
        $this->empID = $user->employee->employee_id;

        // Fetch current disabilities and skills from the database
        $disabilities = Disability::where('employee_id', $this->empID)->get();
        $skills = Skills::where('employee_id', $this->empID)->get();

        // Map disabilities and skills to arrays with proper formatting
        $this->originalDisabilities = $disabilities->map(function ($disability) {
            return [
                'disability_id' => $disability->disability_id,
                'disability_Type' => strtoupper($disability->disability_Type),
            ];
        })->toArray();

        $this->originalSkills = $skills->map(function ($skill) {
            return [
                'skills_id' => $skill->skills_id,
                'skill_Type' => strtoupper($skill->skill_Type),
            ];
        })->toArray();

        // Initialize display arrays
        $this->displayDisabilities = $this->originalDisabilities;
        $this->displaySkills = $this->originalSkills;

        $this->mountData();
    }

    public function mountData()
    {

        $employeeDetails = Employee::findOrFail($this->empID);

        $this->fname = $employeeDetails->fname;
        $this->mname = $employeeDetails->mname;
        $this->lname = $employeeDetails->lname;
        $this->suffix = $employeeDetails->suffix;
        $this->birthdate = Carbon::parse($employeeDetails->birthdate)->format('Y-m-d');
        $this->gender = $employeeDetails->gender;
        $this->civilstatus = $employeeDetails->civilstatus;
        $this->religion = $employeeDetails->religion;
        $this->pnumber = $employeeDetails->pnumber;
        $this->tinnum = $employeeDetails->tinnum;
        $this->height = $employeeDetails->height;
        $this->address = $employeeDetails->address;
        $this->empStatus = $employeeDetails->empstatus;
        $this->updatedEmpStatus();

        $this->empDesc = $employeeDetails->empstatusdesc;

        $this->ofw = $employeeDetails->ofw;
        $this->fourp = $employeeDetails->fourp;
        $this->fourpID = $employeeDetails->fourpID;

        $this->privacy = $employeeDetails->empprofile;

        // dd($employeeDetails->empstatusdesc);

        $this->barangayID = $employeeDetails->barangay_id;

        $barangayDetails = Barangay::find($employeeDetails->barangay_id);
        $this->bar = $barangayDetails->barangay_Name;
        $this->mun = $barangayDetails->municipality->municipality_Name;
        $this->prov = $barangayDetails->municipality->province->province_Name;

    }

    // SEARCH  LIFECYCLE HOOK
    public function updatedSearchLang()
    {
        $this->resetPage('language');
    }

    public function updatedSearchEli()
    {
        $this->resetPage('eligibilities');
    }

    public function updatedSearchLic()
    {
        $this->resetPage('licenses');
    }

// ---------------------------------- PROFILE SECTION ---------------------------------
    //SAVE PROFILE
    public function saveProfile()
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
            'pnumber' => ['required', 'regex:/^09\d{9}$/'],
            'address' => ['required'],
            'bar' => ['required'],
            'mun' => ['required'],
            'prov' => ['required'],
            'empStatus' => ['required'],
            'empDesc' => ['required'],
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
            'pnumber.required' => 'Phone number is required.',
            'pnumber.regex' => 'Phone number must start with 09 and be followed by exactly 9 digits.',
            'address.required' => 'Address is required.',
            'bar.required' => 'Barangay is required.',
            'mun.required' => 'Municipality is required.',
            'prov.required' => 'Province is required.',
            'empStatus.required' => 'Employment Status is required.',
            'empDesc.required' => 'Employment Status Description is required.',

        ];

        $this->validate($rules, $messages);

        $jobseekerData = Employee::findOrFail($this->empID);
        $currentBarangayID = $jobseekerData->barangay_id;
        $currentMunicipalityID = $jobseekerData->barangay->municipality_id;

        if ($currentBarangayID != $this->barangayID) {
            // dd('hello');
            $newBarangayMunicipalityID = Barangay::findOrFail($this->barangayID)->municipality_id;
            // dd($newBarangayMunicipalityID);
            $hasActiveApplications = Job_Applicants::where('employee_id', $this->empID)
                ->whereHas('job_posting.peso', function ($query) use ($currentMunicipalityID) {
                    $query->where('municipality_id', $currentMunicipalityID);
                })
                ->whereNotIn('applicant_Status', ['ACCEPTED', 'REJECTED', 'CANCELLED'])
                ->exists();

            // dd($hasActiveApplications);

            if ($hasActiveApplications && $newBarangayMunicipalityID != $currentMunicipalityID) {
                toastr()->warning('You have active job applications in your current municipality. Please complete  those applications before changing to a barangay in a different municipality.');
                return; // Stop further execution
            }
        }

        $imgPath = null;

        if ($this->pimg) {
            $imgPath = $this->pimg->store('images/user_data', 'public');
        }

        $profileChanged = false;
        $disabilitiesChanged = false;
        $skillsChanged = false;

        DB::beginTransaction();

        try {
            // Delete old image if a new one is uploaded and there is an existing image
            if ($this->pimg && $jobseekerData->pimg) {
                Storage::disk('public')->delete($jobseekerData->pimg);
            }

            // Update model attributes
            $jobseekerData->pimg = $imgPath ?? $jobseekerData->pimg;
            $jobseekerData->fname = $this->fname;
            $jobseekerData->mname = $this->mname;
            $jobseekerData->lname = $this->lname;
            $jobseekerData->suffix = $this->suffix;
            $jobseekerData->height = $this->height;
            $jobseekerData->gender = $this->gender;
            $jobseekerData->civilstatus = $this->civilstatus;
            $jobseekerData->religion = $this->religion;
            $jobseekerData->birthdate = $this->birthdate;
            $jobseekerData->pnumber = $this->pnumber;
            $jobseekerData->address = $this->address;
            $jobseekerData->barangay_id = $this->barangayID;
            $jobseekerData->empstatus = $this->empStatus;
            $jobseekerData->empstatusdesc = $this->empDesc;
            $jobseekerData->tinnum = $this->tinnum;
            $jobseekerData->ofw = $this->ofw;
            $jobseekerData->fourp = $this->fourp;

            if ($this->fourp == 1) {
                $jobseekerData->fourpID = null;

            }

            // Check if any attributes have changed
            if ($jobseekerData->isDirty()) {
                $jobseekerData->save();
                $profileChanged = true;
            }

            // DISABILITIES
            foreach ($this->disabilitiesToRestore as $disID) {
                $disability = Disability::withTrashed()->find($disID);
                if ($disability) {
                    $disability->restore();
                }
                $disabilitiesChanged = true;
            }

            // Add new disabilities
            foreach ($this->disabilitiesToAdd as $disability) {
                if (!in_array($disability['disability_Type'], array_column($this->originalDisabilities, 'disability_Type'))) {
                    Disability::create([
                        'employee_id' => $this->empID,
                        'disability_Type' => $disability['disability_Type'],
                    ]);
                    $disabilitiesChanged = true;
                }
            }
            foreach ($this->disabilitiesToRemove as $disID) {
                $jobseekerData->disability()->find($disID)->delete();
                $disabilitiesChanged = true;

            }

            // foreach ($this->disabilitiesToRemove as $disID) {
            //     Disability::where('disability_id', $disID)
            //         ->where('employee_id', $this->empID)
            //         ->delete();
            //     $disabilitiesChanged = true;
            // }

            // SKILLS

            foreach ($this->skillsToRestore as $skillID) {
                $skills = Skills::withTrashed()->find($skillID);
                if ($skills) {
                    $skills->restore();
                }
                $skillsChanged = true;
            }

            // Add new disabilities
            foreach ($this->skillsToAdd as $skill) {
                if (!in_array($skill['skill_Type'], array_column($this->originalSkills, 'skill_Type'))) {
                    Skills::create([
                        'employee_id' => $this->empID,
                        'skill_Type' => $skill['skill_Type'],
                    ]);
                    $skillsChanged = true;
                }
            }
            foreach ($this->skillsToRemove as $skillID) {
                $jobseekerData->skills()->find($skillID)->delete();
                $skillsChanged = true;

            }

            if ($profileChanged || $disabilitiesChanged || $skillsChanged) {
                DB::commit();
                $this->reset('disabilitiesToAdd', 'disabilitiesToRemove', 'displayDisabilities', 'disabilitiesToRestore',
                    'skillsToAdd', 'skillsToRemove', 'displaySkills', 'skillsToRestore');
                $this->mount();
                toastr()->success('Profile has been updated!');

            } else {
                DB::rollBack();
                $this->reset('disabilitiesToAdd', 'disabilitiesToRemove', 'displayDisabilities', 'disabilitiesToRestore',
                    'skillsToAdd', 'skillsToRemove', 'displaySkills', 'skillsToRestore');
                $this->reset();
                $this->mount();
                toastr()->info('No changes detected.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($imgPath)) {
                Storage::disk('public')->delete($imgPath);
            }
            $this->reset('disabilitiesToAdd', 'disabilitiesToRemove', 'displayDisabilities', 'disabilitiesToRestore',
                'skillsToAdd', 'skillsToRemove', 'displaySkills', 'skillsToRestore');
            $this->mount();
            toastr()->error('There was an error updating the profile.');
        }

    }
    // PROFILE EMP STATUS
    public function updatedEmpStatus()
    {
        // Reset empDesc when empStatus changes
        $this->empDesc = '';

        // Update empDescriptions based on empStatus
        if ($this->empStatus == '1') { // Employed
            $this->empDescriptions = [
                ['value' => 1, 'text' => 'Wage employed'],
                ['value' => 2, 'text' => 'Self-employed'],
                ['value' => 3, 'text' => 'Others'],
            ];
        } elseif ($this->empStatus == '2') { // Unemployed
            $this->empDescriptions = [
                ['value' => 4, 'text' => 'New entrant/fresh graduate'],
                ['value' => 5, 'text' => 'Finished contract'],
                ['value' => 6, 'text' => 'Resigned'],
                ['value' => 7, 'text' => 'Retired'],
                ['value' => 8, 'text' => 'Terminated/Laid off due to calamity'],
                ['value' => 9, 'text' => 'Terminated/Laid off (local)'],
                ['value' => 10, 'text' => 'Terminated/Laid off (abroad)'],
                ['value' => 3, 'text' => 'Others'],
            ];
        } else {
            $this->empDescriptions = [];
        }
    }
    //ADDRESS + POSITIONS
    #[On('barSelect')]
    public function barSelect($id)
    {
        $barangay = Barangay::findOrFail($id);

        if ($barangay) {
            $this->barangayID = $id;
            $this->bar = $barangay->barangay_Name;
            $this->mun = $barangay->municipality->municipality_Name;
            $this->prov = $barangay->municipality->province->province_Name;

        }
    }
    // DISABILITY
    public function saveDisability()
    {
        if ($this->selectDisability === "other") {
            $this->selectDisability = $this->otherDisability;
        }

        $this->validate([
            'selectDisability' => [
                'required', 'string', 'filled',
            ],
        ]);

        $disabilityType = strtoupper($this->selectDisability);

        // Check if the disability is already in the original list, added list, or display list
        if (
            in_array($disabilityType, array_column($this->originalDisabilities, 'disability_Type')) ||
            in_array($disabilityType, array_column($this->disabilitiesToAdd, 'disability_Type')) ||
            in_array($disabilityType, array_column($this->displayDisabilities, 'disability_Type'))
        ) {
            toastr()->warning('This disability has already been added.');
            return;
        }

        // Check if the disability was previously soft deleted
        $softDeletedDisability = Disability::withTrashed()
            ->where('employee_id', $this->empID)
            ->where('disability_Type', $disabilityType)
            ->first();

        if ($softDeletedDisability) {
            // Store the disability for restoration during the save process
            $this->disabilitiesToRestore[] = $softDeletedDisability->disability_id;
            $this->closeModal('disability');
        } else {
            // Add the disability to the to-be-added list
            $this->disabilitiesToAdd[] = ['disability_Type' => $disabilityType];
            $this->closeModal('disability');
        }

        // Add to the display array
        $this->displayDisabilities[] = ['disability_id' => $softDeletedDisability->disability_id ?? null, 'disability_Type' => $disabilityType];
    }

    // SKILLS
    public function saveSkills()
    {
        $this->validate([
            'skills' => [
                'required', 'string', 'filled',
            ],
        ]);

        $skillsType = strtoupper($this->skills);

        // Check if the skill is already in the original list, added list, or display list
        if (
            in_array($skillsType, array_column($this->originalSkills, 'skill_Type')) ||
            in_array($skillsType, array_column($this->skillsToAdd, 'skill_Type')) ||
            in_array($skillsType, array_column($this->displaySkills, 'skill_Type'))
        ) {
            toastr()->warning('This skill has already been added.');
            return;
        }

        // Check if the skill was previously soft deleted
        $softDeletedSkill = Skills::withTrashed()
            ->where('employee_id', $this->empID)
            ->where('skill_Type', $skillsType)
            ->first();

        if ($softDeletedSkill) {
            // Store the skill for restoration during the save process
            $this->skillsToRestore[] = $softDeletedSkill->skills_id;
        } else {
            // Add the skill to the to-be-added list
            $this->skillsToAdd[] = ['skill_Type' => $skillsType];
        }

        // Add to the display array
        $this->displaySkills[] = [
            'skills_id' => $softDeletedSkill->skills_id ?? null,
            'skill_Type' => $skillsType,
        ];

        $this->closeModal('skills');
    }
    // REMOVE DISABILITY
    public function removeDisability($identifier)
    {

        // dd($identifier);
        // Check if the identifier is numeric (indicating it's a disability_id)
        if (is_numeric($identifier)) {
            // Handle removal by disability_id
            $disability = Disability::withTrashed()
                ->where('disability_id', $identifier)
                ->where('employee_id', $this->empID)
                ->first(['disability_id', 'disability_Type']); // Retrieve the first matching record

            if ($disability) {
                // Add to removal list if it exists in the original list
                if (in_array(strtoupper($disability->disability_Type), array_column($this->originalDisabilities, 'disability_Type'))) {
                    $this->disabilitiesToRemove[] = $identifier;
                }

                // Update display list
                $this->displayDisabilities = array_filter($this->displayDisabilities, function ($dis) use ($identifier) {
                    return $dis['disability_id'] !== (int) $identifier;
                });

                // Remove from disabilitiesToAdd if present
                $this->disabilitiesToAdd = array_filter($this->disabilitiesToAdd, function ($dis) use ($disability) {
                    return $dis['disability_Type'] !== $disability->disability_Type;
                });

                // Ensure that disabilitiesToRestore does not include the removed disability
                $this->disabilitiesToRestore = array_filter($this->disabilitiesToRestore, function ($disID) use ($disability) {
                    // $disID should be an ID and compared with $disability->disability_id
                    return $disID !== $disability->disability_id;
                });
            }
        } else {
            // Handle removal by disability_Type
            $disabilityType = strtoupper($identifier);

            // Remove from disabilitiesToAdd if present
            $this->disabilitiesToAdd = array_filter($this->disabilitiesToAdd, function ($dis) use ($disabilityType) {
                return $dis['disability_Type'] !== $disabilityType;
            });

            // Remove from displayDisabilities
            $this->displayDisabilities = array_filter($this->displayDisabilities, function ($dis) use ($disabilityType) {
                return $dis['disability_Type'] !== $disabilityType;
            });
        }

        $this->closeModal('disability');
        // toastr()->info('Disability will be removed when you save the profile.');
    }
    // REMOVE SKILLS
    public function removeSkills($identifier)
    {

        if (is_numeric($identifier)) {
            // Handle removal by skills_id
            $skill = Skills::withTrashed()
                ->where('skills_id', $identifier)
                ->where('employee_id', $this->empID)
                ->first(['skills_id', 'skill_Type']); // Retrieve the first matching record

            if ($skill) {
                // Add to removal list if it exists in the original list
                if (in_array(strtoupper($skill->skill_Type), array_column($this->originalSkills, 'skill_Type'))) {
                    $this->skillsToRemove[] = $identifier;
                }

                // Update display list
                $this->displaySkills = array_filter($this->displaySkills, function ($dis) use ($identifier) {
                    return $dis['skills_id'] !== (int) $identifier;
                });

                // Remove from skillsToAdd if present
                $this->skillsToAdd = array_filter($this->skillsToAdd, function ($dis) use ($skill) {
                    return $dis['skill_Type'] !== $skill->skill_Type;
                });

                // Ensure that skillsToRestore does not include the removed skill
                $this->skillsToRestore = array_filter($this->skillsToRestore, function ($disID) use ($skill) {
                    return $disID !== $skill->skills_id;
                });
            }
        } else {
            // Handle removal by skill_Type
            $skillType = strtoupper($identifier);

            // Remove from skillsToAdd if present
            $this->skillsToAdd = array_filter($this->skillsToAdd, function ($dis) use ($skillType) {
                return $dis['skill_Type'] !== $skillType;
            });

            // Remove from displaySkills
            $this->displaySkills = array_filter($this->displaySkills, function ($dis) use ($skillType) {
                return $dis['skill_Type'] !== $skillType;
            });
        }

        $this->closeModal('skills');
    }
// ---------------------------------- LANGUAGE - LICENSE - ELIGIBLITY ---------------------------------

    // LANGUAGE
    public function saveLanguage()
    {

        $rules = [
            'selectedLanguage' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Check if the selected language already exists for the employee
                    $existingLanguage = Language::where('employee_id', $this->empID)
                        ->where('language_Type', $value === 'other' ? $this->otherLanguage : $value)
                        ->first();

                    if ($existingLanguage && $existingLanguage->language_id !== $this->langID) {
                        $fail('The selected language has already been added.');
                    }
                },
            ],
            'otherLanguage' => [
                'required_if:selectedLanguage,other',
                'nullable',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Check if the "other" language already exists for the employee
                    if ($this->selectedLanguage === 'other') {
                        $existingLanguage = Language::where('employee_id', $this->empID)
                            ->where('language_Type', $value)
                            ->first();

                        if ($existingLanguage && $existingLanguage->language_id !== $this->langID) {
                            $fail('The language "' . $value . '" has already been added.');
                        }
                    }
                },
            ],
        ];

        $messages = [
            'selectedLanguage.required' => 'Please select a language.',
            'otherLanguage.required_if' => 'The other language field is required when the selected language is "other".',
            'otherLanguage.max' => 'Language must only have 255 characters.',
        ];

        $this->validate($rules, $messages);
        // Custom validation for at least one being true
        if (!$this->read && !$this->write && !$this->speak && !$this->understand) {
            $this->addError('language_option', 'At least one of the options for read, write, speak, or understand must be selected.');
            return;
        }
        DB::beginTransaction();

        try {
            if ($this->langID) {
                $language = Language::where('language_id', $this->langID)
                    ->where('employee_id', $this->empID)
                    ->firstOrFail();

                // Update model attributes
                $language->employee_id = $this->empID;
                $language->language_Type = $this->selectedLanguage === 'other' ? $this->otherLanguage : $this->selectedLanguage;
                $language->language_Read = $this->read === true ? 1 : 2;
                $language->language_Write = $this->write === true ? 1 : 2;
                $language->language_Speak = $this->speak === true ? 1 : 2;
                $language->language_Understand = $this->understand === true ? 1 : 2;

                // Check if any attributes have changed
                if ($language->isDirty()) {
                    $language->save();
                    toastr()->success('Language Record has been updated!');
                } else {
                    toastr()->info('No changes detected.');
                }
            } else {
                Language::create([
                    'employee_id' => $this->empID,
                    'language_Type' => $this->selectedLanguage === 'other' ? $this->otherLanguage : $this->selectedLanguage,
                    'language_Read' => $this->read === true ? 1 : 2,
                    'language_Write' => $this->write === true ? 1 : 2,
                    'language_Speak' => $this->speak === true ? 1 : 2,
                    'language_Understand' => $this->understand === true ? 1 : 2,
                ]);

                toastr()->success('Language Record has been added!');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating language: ' . $e->getMessage());
            toastr()->error('There was an error updating the language record.');
        }

        $this->closeModal('language');
    }
    //ELIGIBILITY
    public function saveEligibility()
    {
        // Define validation rules
        $rules = [
            'eli_Date' => [
                'required',
                'date',
                'after:today', // Ensure the date is in the future
            ],
            'eliTypeID' => [
                'required',
                Rule::unique('eligibility', 'eligibility_Type') // Specify the correct column name
                    ->where(function ($query) {
                        // Ensure uniqueness for this employee and exclude trashed records
                        $query->where('employee_id', $this->empID)
                            ->whereNull('deleted_at'); // Exclude trashed records
                    })
                    ->ignore($this->eliID, 'eligibility_id'), // Ignore the current record when updating
            ],
        ];

        // Define custom validation messages
        $messages = [
            'eli_Date.required' => 'The eligibility date is required.',
            'eli_Date.date' => 'The eligibility date must be a valid date.',
            'eli_Date.after' => 'The eligibility date must be a future date.',
            'eliTypeID.required' => 'The eligibility type is required.',
            'eliTypeID.unique' => 'The eligibility type has already been taken for this user.',
        ];

        // Validate input
        $this->validate($rules, $messages);

        DB::beginTransaction(); // Start transaction

        try {
            if ($this->eliID) {
                // Update existing record
                $eligibility = Eligibility::findOrFail($this->eliID);
                $eligibility->update([
                    'eligibility_Type' => $this->eliTypeID,
                    'eligibility_Date' => $this->eli_Date,
                ]);

                toastr()->success('Eligibility Record has been Updated!');
            } else {
                // Create new record
                Eligibility::create([
                    'employee_id' => $this->empID,
                    'eligibility_Type' => $this->eliTypeID,
                    'eligibility_Date' => $this->eli_Date,
                ]);

                toastr()->success('Eligibility Record has been Added!');
            }

            DB::commit(); // Commit transaction
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction
            Log::error('Error updating eligibility: ' . $e->getMessage());
            toastr()->error('There was an error, please try again later.');
        }

        $this->closeModal('eligibility');
    }
    //LICENSE
    public function saveLicense()
    {
        // Define validation rules
        $rules = [
            'licValidity' => [
                'required',
                'date',
                'after:today', // Ensure the date is in the future
            ],
            'licTypeID' => [
                'required',
                Rule::unique('license', 'license_type_id') // Specify the correct column name
                    ->where(function ($query) {
                        // Ensure uniqueness for this employee and exclude trashed records
                        $query->where('employee_id', $this->empID)
                            ->whereNull('deleted_at'); // Exclude trashed records
                    })
                    ->ignore($this->licID, 'license_id'), // Ignore the current record when updating
            ],
        ];

        // Define custom validation messages
        $messages = [
            'licValidity.required' => 'The license validity date is required.',
            'licValidity.date' => 'The license validity date must be a valid date.',
            'licValidity.after' => 'The license validity date must be a future date.',
            'licTypeID.required' => 'The license type is required.',
            'licTypeID.unique' => 'The license type has already been taken for this user.',
        ];

        // Validate input
        $this->validate($rules, $messages);

        DB::beginTransaction(); // Start transaction

        try {
            if ($this->licID) {
                // Update existing record
                $license = License::findOrFail($this->licID);
                $license->update([
                    'license_type_id' => $this->licTypeID,
                    'license_Validity' => $this->licValidity, // Ensure column name matches
                ]);

                toastr()->success('License Record has been Updated!');
            } else {
                // Create new record
                License::create([
                    'employee_id' => $this->empID,
                    'license_type_id' => $this->licTypeID,
                    'license_Validity' => $this->licValidity, // Ensure column name matches
                ]);

                toastr()->success('License Record has been Added!');
            }

            DB::commit(); // Commit transaction
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction
            Log::error('Error updating license: ' . $e->getMessage());
            toastr()->error('There was an error, please try again later.');

        }

        $this->closeModal('license');
    }

    // DELETE LANGUAGE - ELIGIBLITY - LICENSE
    public function deleteRecord($type)
    {
        DB::beginTransaction();
        try {
            if ($type == 1) {
                $eligibility = Eligibility::findOrFail($this->deleteEli);

                $eligibility->delete();

                $this->dispatch('close-modal', 'delete-eligibility-modal');
                toastr()->success('Eligibilty record has been successfully deleted!');

            } elseif ($type == 2) {
                $license = License::findOrFail($this->deleteLic);
                $license->delete();
                $this->dispatch('close-modal', 'delete-license-modal');
                toastr()->success('License record has been successfully deleted!');

            } elseif ($type == 3) {
                $language = Language::findOrFail($this->deleteLang);
                $language->delete();
                $this->dispatch('close-modal', 'delete-language-modal');
                toastr()->success('Language record has been successfully deleted!');

            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting language: ' . $e->getMessage());
            toastr()->error('There was an error, please try again later.');
        }

        $this->reset('deleteEli', 'deleteLic', 'deleteLang');
    }

    //MODAL LANGUAGE - ELIGIBLITY - LICENSE
    public function openModal($modalName)
    {

        if ($modalName == "disability") {
            $this->reset('selectDisability', 'otherDisability', );
            $this->dispatch('open-modal', 'disability-modal');
        } elseif ($modalName == "skills") {
            $this->reset('skills');
            $this->dispatch('open-modal', 'skills-modal');
        } elseif ($modalName == "language") {
            $this->reset('read', 'write', 'speak', 'understand', 'otherLanguage');
            $this->selectedLanguage = '';
            $this->dispatch('open-modal', 'language-modal');
        } elseif ($modalName == "eligibility") {
            $this->reset('eliID', 'eli_Name', 'eli_Date', 'searchLang', 'searchEli', 'searchLic', 'searchLi', 'searchEl');
            $this->dispatch('open-modal', 'eligibility-modal');
        } elseif ($modalName == "license") {
            $this->reset('licID', 'licName', 'licValidity', 'searchLang', 'searchEli', 'searchLic', 'searchLi', 'searchEl');
            $this->dispatch('open-modal', 'license-modal');
        }
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal($modalName)
    {

        if ($modalName == "disability") {
            $this->reset('selectDisability', 'otherDisability');
            $this->dispatch('close-modal', 'disability-modal');
        } elseif ($modalName == "skills") {
            $this->reset('skills');
            $this->dispatch('close-modal', 'skills-modal');
        } elseif ($modalName == "language") {
            $this->reset('read', 'write', 'speak', 'understand', 'otherLanguage');
            $this->selectedLanguage = '';
            $this->dispatch('close-modal', 'language-modal');
        } elseif ($modalName == "eligibility") {
            $this->reset('eliID', 'eli_Name', 'eli_Date', 'searchLang', 'searchEli', 'searchLic', 'searchLi', 'searchEl');
            $this->dispatch('close-modal', 'eligibility-modal');
        } elseif ($modalName == "license") {
            $this->reset('licID', 'licName', 'licValidity', 'searchLang', 'searchEli', 'searchLic', 'searchLi', 'searchEl');
            $this->dispatch('close-modal', 'license-modal');
        }
        $this->resetValidation();
    }

    public function deleteData($type, $id)
    {
        $this->reset('deleteEli', 'deleteLic', 'deleteLang');

        if ($type == 1) {
            $this->deleteEli = $id;
            $this->dispatch('open-modal', 'delete-eligibility-modal');

        } elseif ($type == 2) {
            $this->deleteLic = $id;
            $this->dispatch('open-modal', 'delete-license-modal');

        } elseif ($type == 3) {
            $this->deleteLang = $id;
            $this->dispatch('open-modal', 'delete-language-modal');

        }

    }

    //SET VARIABLES
    public function setVar($id, $name)
    {
        if ($name == "eligibility") {
            $this->reset('searchLang', 'searchEli', 'searchLic', 'searchLi', 'searchEl');

            $eligibilityType = Eligibility_Type::find($id);
            $this->eli_Name = $eligibilityType->eligibility_Name;
            $this->eliTypeID = $id;
        } elseif ($name == "license") {
            $this->reset('searchLang', 'searchEli', 'searchLic', 'searchLi', 'searchEl');

            $licenseType = License_Type::find($id);
            $this->licName = $licenseType->license_Name;
            $this->licTypeID = $id;
        }
    }
    public function editRecord($id, $name)
    {
        $this->resetErrorBag();
        $this->resetValidation();
        if ($name == 'language') {
            $this->langID = $id;

            $languageData = Language::find($id);

            // Mapping language types to selectedLanguage values
            $languageTypeMap = [
                'English' => 'English',
                'Filipino' => 'Filipino',
                'Mandarin' => 'Mandarin',
            ];

            $this->selectedLanguage = $languageTypeMap[$languageData->language_Type] ?? 'other';
            $this->otherLanguage = $this->selectedLanguage == 'other' ? $languageData->language_Type : null;

            // Boolean flags based on database values
            $this->read = $languageData->language_Read == '1';
            $this->write = $languageData->language_Write == '1';
            $this->speak = $languageData->language_Speak == '1';
            $this->understand = $languageData->language_Understand == '1';

            $this->dispatch('open-modal', 'language-modal');

        }

        if ($name == "license") {
            $this->licID = $id;

            $licenseData = License::find($id);
            $this->licName = $licenseData->license_type->license_Name;
            $this->licValidity = Carbon::parse($licenseData->license_Validity)->format('Y-m-d');

            $this->licTypeID = $licenseData->license_type_id;

            $this->dispatch('open-modal', 'license-modal');
        } elseif ($name == "eligibility") {
            $this->reset('searchLang', 'searchEli', 'searchLic', 'searchLi', 'searchEl');
            $this->eliID = $id;
            $this->dispatch('open-modal', 'eligibility-modal');

            $eliData = Eligibility::find($id);
            $this->eli_Name = $eliData->eligibility_type->eligibility_Name;
            $this->eli_Date = Carbon::parse($eliData->eligibility_Date)->format('Y-m-d');

            $this->eliTypeID = $eliData->eligibility_Type;
        }
    }

// ---------------------------------- JOB PREFERENCE INDUSTRY PREFERENCE ---------------------------------

    #[On('positionSelect')]
    public function positionSelect($id)
    {
        $positionExist = Job_Preference::where('position_id', $id)
            ->where('employee_id', $this->empID)->exists();
        if ($positionExist) {
            toastr()->warning('This job position is already selected.');
            return;
        }
        $jobPreferenceCount = Job_Preference::where('employee_id', $this->empID)->count();
        if ($jobPreferenceCount >= 12) {
            // Prevent deletion if there's only one job preference left
            toastr()->warning('You can only select up to 12 job preferences.');
            return;
        }

        $jobposition = Job_Positions::find($id);

        if ($jobposition) {
            Job_Preference::create([
                'employee_id' => $this->empID,
                'position_id' => $id,
            ]);
            toastr()->success('Job preference added.');

            $this->dispatch('close-modal', 'job-position-modal');
        } else {
            toastr()->error('Could not fetch data');
            $this->dispatch('close-modal', 'job-position-modal');
        }
    }

    #[On('industrySelect')]
    public function industrySelect($id)
    {

        $industryExist = Industry_Preference::where('industry_id', $id)
            ->where('employee_id', $this->empID)->exists();
        if ($industryExist) {
            toastr()->warning('This job industry is already selected.');
            return;
        }

        $industryPreferenceCount = Industry_Preference::where('employee_id', $this->empID)->count();

        if ($industryPreferenceCount >= 3) {
            toastr()->warning('You can only select up to 3 industries.');
            return;
        }

        $industry = Job_Industry::find($id);

        if ($industry) {
            Industry_Preference::create([
                'employee_id' => $this->empID,
                'industry_id' => $id,
            ]);
            toastr()->success('Job industry added.');

            $this->dispatch('close-modal', 'industry-modal');
        } else {
            toastr()->error('Could not fetch data');
            $this->dispatch('close-modal', 'industry-modal');
        }
    }

    public function removePosition($positionId)
    {
        // Check if the employee has more than one job preference
        $jobPreferenceCount = Job_Preference::where('employee_id', $this->empID)->count();

        if ($jobPreferenceCount <= 1) {
            // Prevent deletion if there's only one job preference left
            toastr()->error('You must have at least one job preference.');
            return;
        }

        DB::beginTransaction();

        try {
            // Perform the delete operation
            Job_Preference::where('job_preference_id', $positionId)
                ->where('employee_id', $this->empID)
                ->delete();

            // Commit the transaction if the operation is successful
            DB::commit();

            toastr()->success('Job Preference record has been deleted.');
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();
            toastr()->error('There was an error, please try again later.');

            // Optionally log the exception for debugging
            Log::error('Error removing job preference: ' . $e->getMessage());
        }
    }

    public function removeIndustry($industryId)
    {
        // Check if the employee has more than one industry preference
        $industryPreferenceCount = Industry_Preference::where('employee_id', $this->empID)->count();

        if ($industryPreferenceCount <= 1) {
            // Prevent deletion if there's only one industry preference left
            toastr()->error('You must have at least one industry preference.');
            return;
        }

        DB::beginTransaction(); // Start the transaction

        try {
            // Find the Industry_Preference record or fail
            $industryPreference = Industry_Preference::where('industry_pref_id', $industryId)
                ->where('employee_id', $this->empID)
                ->firstOrFail();

            // Delete the record
            $industryPreference->delete();

            DB::commit(); // Commit the transaction

            toastr()->success('Industry Preference record has been deleted.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on general exceptions
            Log::error('Error removing industry preference: ' . $e->getMessage());
            toastr()->error('There was an error, please try again later.');
        }
    }

// ---------------------------------- RESUME SECTION ---------------------------------

    // VIEW RESUME
    public function viewFile($id, $fileToView)
    {
        $this->dispatch('viewFile', [
            'url' => route('view.resume'),
            'emp_id' => $id,
            'resume_type' => $fileToView,
        ]);

    }

    // SAVE RESUME
    public function saveResume()
    {
        $this->validate([
            'newResume' => ['required', 'file', 'mimes:pdf', 'max:15360'], // 'max' is in kilobytes (5MB = 5120KB)
        ], [
            'newResume.required' => 'The resume file is required.',
            'newResume.file' => 'The resume must be a file.',
            'newResume.mimes' => 'The resume must be a PDF file.',
            'newResume.max' => 'The resume may not be greater than 15MB in size.',
        ]);

        // Start a transaction
        DB::beginTransaction();

        try {
            // Upload the new resume
            $resumePath = $this->newResume->store('resumes', 'public');

            // Retrieve the current employee's record
            $employee = Employee::findOrFail($this->empID);

            // Delete the old resume if it exists
            if ($employee->resume) {
                Storage::disk('public')->delete($employee->resume);
            }

            // Update the employee's record with the new resume path
            $employee->update([
                'resume' => $resumePath,
            ]);

            // Commit the transaction
            DB::commit();

            toastr()->success('Resume uploaded and updated successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Delete the newly uploaded resume file
            if (isset($resumePath)) {
                Storage::disk('public')->delete($resumePath);
            }
            Log::error('Error updating resume: ' . $e->getMessage());
            toastr()->error('There was an error in uploading the resume!');
        }

        $this->reset('newResume');
    }

// ---------------------------------- PRIVACY SECTION ---------------------------------

    // SAVE PRIVACY
    public function savePrivacy()
    {
        $rules = [
            'privacy' => ['required'],
        ];

        $messages = [
            'privacy.required' => 'The privacy option is required.',
        ];

        $this->validate($rules, $messages);

        $jobseekerData = Employee::findOrFail($this->empID);

        DB::beginTransaction();

        try {

            $jobseekerData->empprofile = $this->privacy;

            // Check if any attributes have changed
            if ($jobseekerData->isDirty()) {
                $jobseekerData->save();

                DB::commit();

                toastr()->success('Profile privacy has been updated!');
            }else{
                
                toastr()->info('No changes detected!');

            }


        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating privacy: ' . $e->getMessage());

            toastr()->error('There was an error updating the profile.');
        }
    }
    public function render()
    {

        $elTypes = Eligibility_Type::where('eligibility_Name', 'like', '%' . $this->searchEl . '%')->get();
        $liTypes = License_Type::where('license_Name', 'like', '%' . $this->searchLi . '%')->get();

        $employeeDetails = Employee::with([
            'job_preference',
            'industry_preference',
            'language',
        ])->find($this->empID);

        $employeeEli = $employeeDetails->eligibility()->whereHas('eligibility_type', function ($q) {
            $q->where('eligibility_Name', 'like', '%' . $this->searchEli . '%');
        })->orderBy('created_at', 'desc')->paginate(10, ['*'], 'eligibilities');
        $employeeLic = $employeeDetails->license()->whereHas('license_type', function ($q) {
            $q->where('license_Name', 'like', '%' . $this->searchLic . '%');
        })->orderBy('created_at', 'desc')->paginate(10, ['*'], 'licenses');
        $employeeLang = $employeeDetails->language()->where('language_Type', 'like', '%' . $this->searchLang . '%')->paginate(10, ['*'], 'language'); // Adjust 10 to your desired per-page limit

        return view(
            'livewire.public.profile.jobseeker.partials.edit-details',
            compact('employeeDetails', 'elTypes', 'liTypes', 'employeeEli', 'employeeLic', 'employeeLang')
        );
    }
}
