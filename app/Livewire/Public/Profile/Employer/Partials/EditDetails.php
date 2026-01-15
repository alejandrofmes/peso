<?php

namespace App\Livewire\Public\Profile\Employer\Partials;

use App\Models\Barangay;
use App\Models\Company;
use App\Models\Company_Industry_Line;
use App\Models\Job_Industry;
use App\Models\Partnerships;
use App\Models\PESO;
use App\Models\Requirements;
use App\Models\Requirements_Passed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

    public $search, $searchMun;

    public $selMun, $selProv, $selID, $agreeBox = false, $reapplyID;

    public $req = [];

    // COMPANY INFORMATION
    #[Validate]
    public $companyImage;

    public $businessName, $tradeName, $tin, $locType, $workforce, $empType, $empDesc, $companyAddress;
    public $barangayID, $bar, $mun, $prov;

    // CONTACT PERSON
    public $contactPerson, $contactPosition, $contactPnum, $contactTnum, $contactFnum, $contactEmail;

    public $industrypreference;

    public $partnershipRemarks;

    public function rules()
    {
        return [
            // BASIC INFORMATION
            'companyImage' => 'nullable|image|mimes:jpeg,png,jpg',
        ];
    }
    public function messages()
    {
        return [
            'companyImage.image' => 'The file must be an image.',
            'companyImage.mimes' => 'The image must be of type: jpeg, png, jpg.',
            // 'pimg.max' => 'The image size must not exceed 5 MB.',
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function selectBranch($id)
    {

        $pesoBranch = PESO::findOrFail($id);

        if ($pesoBranch) {
            $this->selID = $pesoBranch->peso_id;
            $this->selMun = $pesoBranch->municipality->municipality_Name;
            $this->selProv = $pesoBranch->municipality->province->province_Name;
        } else {
            toastr()->error('There was en error selecting the municipality.');
        }
    }

    public function viewFile($id)
    {
        // dd($id);
        $this->dispatch('viewFile', [
            'url' => route('view.requirement'),
            'req_passed_id' => $id,
        ]);

    }

    public function reapplyClick($id)
    {
        $this->agreeBox = false;
        $this->reapplyID = $id;

        $this->dispatch('open-modal', 'partnership-reapply-modal');

    }

    public function reapplyPartnership()
    {
        $rules = [
            'agreeBox' => 'required|boolean',
        ];

        $messages = [
            'agreeBox.required' => 'Please check the agreement box before proceeding.',
        ];

        $this->validate($rules, $messages);

        $partnership = Partnerships::findOrFail($this->reapplyID);

        if ($partnership) {
            DB::beginTransaction();
            try {
                $partnership->partnership_Status = 'PENDING';
                $partnership->responded_at = null;
                $partnership->save();

                DB::commit(); // Commit the transaction
                toastr()->success('Partnership reapplied successfully.');

            } catch (\Exception $e) {
                DB::rollBack(); // Rollback the transaction in case of error
                toastr()->error('There was an error with partnership. Please try again later.');
            }

        } else {
            toastr()->error('There was an reapplying the partnership. Please try again later.');

        }
        $this->closeModal('partnership-reapply');

    }

    public function applyPartnership()
    {
        // Define validation rules and custom messages
        $rules = [
            'selID' => 'required|integer',
            'agreeBox' => 'required|boolean',
        ];

        $messages = [
            'selID.required' => 'Municipality is required.',
            'agreeBox.required' => 'Please check the agreement box before proceeding.',
        ];

        // Validate the input data
        $this->validate($rules, $messages);

        // Check if a partnership with the same peso_id and company_id already exists
        $existingPartnership = Partnerships::where('peso_id', $this->selID)
            ->where('company_id', $this->empID)
            ->first();

        if ($existingPartnership) {
            // If a partnership already exists, show an error message
            toastr()->error('A partnership record with this municipality and company already exists.');
            return;
        }

        // Proceed with creating the new partnership
        DB::beginTransaction();

        try {
            // Create a new partnership record
            Partnerships::create([
                'peso_id' => $this->selID,
                'company_id' => $this->empID,
                // Add any additional fields if necessary
            ]);

            DB::commit(); // Commit the transaction
            toastr()->success('Partnership created successfully.');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction in case of error
            toastr()->error('There was an error creating the partnership. Please try again later.');
        }

        // Optionally, reset the form fields or close the modal

        $this->closeModal('partnership-apply');
    }

    public function closeModal($modal)
    {
        $this->reset('selID', 'agreeBox', 'reapplyID');
        $this->dispatch('close-modal', $modal . '-modal');

    }

    public function saveCompany()
    {

        $rules = [
            'workforce' => ['required'],
            'companyAddress' => ['required'],
            'bar' => ['required'],
            'mun' => ['required'],
            'prov' => ['required'],
        ];

        $messages = [
            'workforce.required' => 'Total workforce is required.',
            'companyAddress.required' => 'Address is required.',
            'bar.required' => 'Barangay is required.',
            'mun.required' => 'Municipality is required.',
            'prov.required' => 'Province is required.',
        ];

        $this->validate($rules, $messages);

        $companyData = Company::findOrFail($this->empID);
        $imgPath = null;

        if ($this->companyImage) {
            $imgPath = $this->companyImage->store('images/user_data', 'public');
        }

        DB::beginTransaction();

        try {

            // Delete old image if a new one is uploaded and there is an existing image
            if ($this->companyImage && $companyData->companyImage) {
                Storage::disk('public')->delete($companyData->company_img);
            }

            // Update model attributes
            $companyData->company_img = $imgPath ?? $companyData->company_img;
            $companyData->company_Address = $this->companyAddress;
            $companyData->company_Total_workforce = $this->workforce;
            $companyData->barangay_id = $this->barangayID;

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
    }

    public function saveContact()
    {

        $rules = [
            'contactPerson' => ['required', 'string'],
            'contactPosition' => ['required', 'string'],
            'contactPnum' => ['required', 'regex:/^09\d{9}$/'], // must start with "09" and be followed by 9 digits
            'contactTnum' => ['nullable', 'regex:/^0[0-9]{9,10}$/'],
            'contactFnum' => ['nullable', 'digits:10'], // must have 10 digits
            'contactEmail' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
        ];

        $messages = [
            'contactPerson.required' => 'The contact person is required.',
            'contactPosition.required' => 'The contact position is required.',
            'contactPnum.required' => 'The contact mobile number is required.',
            'contactPnum.regex' => 'The contact mobile number must start with "09" and contain 11 digits.',
            'contactTnum.required' => 'The contact telephone number is required.',
            'contactTnum.regex' => 'The telephone number must start with "0" and contain 10 or 11 digits.',
            // 'contactFnum.required' => 'The contact fax number is required.',
            'contactFnum.digits' => 'The contact fax number must have exactly 10 digits.',
            // 'contactEmail.required' => 'The contact email is required.',
            'contactEmail.email' => 'The contact email must be a valid email address.',
            'contactEmail.regex' => 'The contact email must be a valid email address.',
        ];

        $this->validate($rules, $messages);

        $companyData = Company::findOrFail($this->empID);

        DB::beginTransaction();

        try {

            // Update model attributes
            $companyData->contact_Person = $this->contactPerson;
            $companyData->contact_Person_position = $this->contactPosition;
            $companyData->company_Pnum = $this->contactPnum;
            $companyData->company_Tnum = $this->contactTnum;
            $companyData->company_Fnum = $this->contactFnum;
            $companyData->company_Email = $this->contactEmail;

            // Check if any attributes have changed
            if ($companyData->isDirty()) {
                $companyData->save();
                DB::commit();
                toastr()->success('Contact information has been updated!');
            } else {
                DB::rollBack();
                toastr()->info('No changes detected.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('There was an error updating the contact information.');
        }
    }

    //ADDRESS + POSITIONS
    #[On('barSelect')]
    public function barSelect($id)
    {
        // dd($id);
        $barangay = Barangay::findOrFail($id);

        if ($barangay) {
            // dd($barangay);
            $this->barangayID = $id;
            $this->bar = $barangay->barangay_Name;
            $this->mun = $barangay->municipality->municipality_Name;
            $this->prov = $barangay->municipality->province->province_Name;
        }
        // $this->skipRender();
    }

    #[On('industrySelect')]
    public function industrySelect($id)
    {
        $this->resetVal();

        $industryExist = Company_Industry_Line::where('industry_id', $id)
            ->where('company_id', $this->empID)->exists();
        if ($industryExist) {
            toastr()->warning('This job industry is already selected.');
            return;
        }

        $industryLineCount = Company_Industry_Line::where('company_id', $this->empID)->count();

        if ($industryLineCount >= 3) {
            toastr()->warning('You can only select up to 3 industries.');
            return;
        }

        $industry = Job_Industry::find($id);

        if ($industry) {
            Company_Industry_Line::create([
                'company_id' => $this->empID,
                'industry_id' => $id,
            ]);
            toastr()->warning('Company industry added.');
            $this->dispatch('close-modal', 'industry-modal');
        } else {
            toastr()->error('Could not fetch data');
            $this->dispatch('close-modal', 'industry-modal');
        }
    }

    public function removeIndustry($industryId)
    {
        DB::beginTransaction(); // Start transaction

        try {
            // Check the count of industry lines associated with the company
            $industryCount = Company_Industry_Line::where('company_id', $this->empID)->count();

            if ($industryCount <= 1) {
                toastr()->warning('The company must have at least one industry line.');
                $this->addError('industrypreference', 'A company must have at least 1 industry line.');
                DB::rollBack(); // Rollback transaction if validation fails
                return; // Exit the function early if only one industry line exists
            }

            // Find the industry line to delete
            $industryLine = Company_Industry_Line::where('company_industry_line_id', $industryId)
                ->where('company_id', $this->empID)
                ->firstOrFail();

            // Proceed to delete the industry line
            $industryLine->delete();

            DB::commit(); // Commit transaction
            toastr()->success('Industry Line record has been deleted.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack(); // Rollback transaction if record not found

            toastr()->error('Industry Line record not found.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on other errors

            toastr()->error('There was an error, please try again later');

        }
    }

    public function saveReq()
    {
        // Define validation rules and messages
        $rules = [
            'req.*' => 'nullable|file|mimes:pdf|max:15360', // Max size 5MB, PDF only
        ];

        $messages = [
            'req.*.mimes' => 'Uploaded file must be a PDF.',
            'req.*.max' => 'Uploaded file must be under 15MB.',
        ];

        $this->validate($rules, $messages);

        // Check if there are files to process
        if ($this->req) {
            // Begin a database transaction
            DB::beginTransaction();

            // Array to keep track of paths of successfully uploaded files
            $uploadedPaths = [];

            try {
                foreach ($this->req as $requirementId => $file) {
                    if ($file && $file->isValid()) { // Check if file is valid
                        // Retrieve the old record
                        $oldRequirement = Requirements_Passed::where('company_id', $this->empID)
                            ->where('requirement_id', $requirementId)
                            ->first();

                        // Store the new file
                        $path = $file->store('requirements', 'public');
                        $uploadedPaths[$requirementId] = $path;

                        // Update or create the requirement record
                        Requirements_Passed::updateOrCreate(
                            ['company_id' => $this->empID, 'requirement_id' => $requirementId],
                            ['req_passed_Input' => $path]
                        );

                        // Delete old file if a new file is uploaded
                        if ($oldRequirement && $oldRequirement->req_passed_Input) {
                            Storage::disk('public')->delete($oldRequirement->req_passed_Input);
                        }
                    }
                }

                // Commit the transaction
                DB::commit();

                toastr()->success('Requirements have been updated!');
            } catch (\Exception $e) {
                // Rollback the transaction if something goes wrong
                DB::rollBack();

                // Delete all successfully uploaded files if an error occurs
                foreach ($uploadedPaths as $path) {
                    Storage::disk('public')->delete($path);
                }

                toastr()->error('An error occurred while updating requirements: ' . $e->getMessage());
            }
        } else {
            toastr()->info('No changes detected.');
        }
    }

    public function mountData()
    {
        // dd('hello');

        $employerDetails = Company::with(['company_industry_line'])
            ->findOrFail($this->empID);

        // COMPANY DETAILS
        $this->businessName = $employerDetails->business_Name;
        $this->tradeName = $employerDetails->trade_Name;
        $this->tin = $employerDetails->company_TIN;
        $this->locType = $employerDetails->company_Type;
        $this->workforce = $employerDetails->company_Total_workforce;
        $this->empType = $employerDetails->employer_Type;
        $this->empDesc = $employerDetails->employer_Type_Desc;
        $this->companyAddress = $employerDetails->company_Address;
        $this->barangayID = $employerDetails->barangay_id;

        //CONTACT PERSON
        $this->contactPerson = $employerDetails->contact_Person;
        $this->contactPosition = $employerDetails->contact_Person_position;
        $this->contactPnum = $employerDetails->company_Pnum;
        $this->contactTnum = $employerDetails->company_Tnum;
        $this->contactFnum = $employerDetails->company_Fnum;
        $this->contactEmail = $employerDetails->company_Email;

        $this->barSelect($employerDetails->barangay_id);

        $this->resetVal();
    }

    public function resetVal()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount()
    {
        $user = Auth::user();
        $this->empID = $user->company->company_id;
        $this->mountData();
    }

    public function viewPartnership($id)
    {
        $this->reset('partnershipRemarks');

        $partnershipInfo = Partnerships::findOrFail($id);

        if ($partnershipInfo) {
            $this->partnershipRemarks = $partnershipInfo->partnership_Remarks;
            $this->dispatch('open-modal', 'partnership-info-modal');
        } else {
            toastr()->error('There was an error fetching the information. Please try again later.');
        }

    }

    public function render()
    {

        // Fetch Requirements with related RequirementPassed data
        $requirements = Requirements::with([
            'requirementPassed' => function ($query) {
                $query->where('company_id', $this->empID); // Use `where` for filtering
            },
        ])
            ->where('requirement_Status', 1)
            ->where('requirement_Type', $this->empType)
            ->get();

        $partnerships = Partnerships::where('company_id', $this->empID)
            ->where(function ($query) {
                if (!empty($this->search)) {
                    $query->whereHas('peso.municipality', function ($query) {
                        $query->where('municipality_Name', 'like', '%' . $this->search . '%');
                    });
                }
            })
            ->paginate(10);

        // dd($partnerships);

        // Fetch Peso records with the specified municipality name and not in partnerships with the given company_id
        $pesoNotInPartnerships = PESO::whereDoesntHave('partnerships', function ($query) {
            $query->where('company_id', $this->empID);
        })
            ->whereHas('municipality', function ($query) {
                $query->where('municipality_Name', 'like', '%' . $this->searchMun . '%');
            })
            ->get();

        $employerDetails = Company::with(['company_industry_line'])
            ->findOrFail($this->empID);

        return view('livewire.public.profile.employer.partials.edit-details', compact('employerDetails', 'requirements', 'partnerships', 'pesoNotInPartnerships'));
    }
}
