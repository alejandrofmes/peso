<?php

namespace App\Livewire\Signup\Employer;

use App\Mail\WelcomeCompany;
use App\Models\Company;
use App\Models\Company_Industry_Line;
use App\Models\Partnerships;
use App\Models\Requirements_Passed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.empty')]
class EmployerInformation extends Component
{

    public $formData = [];

    public $currentStep = 1;

    #[On('handleStepData')]
    public function handleStepData($stepNumber, $data)
    {
        $this->formData[$stepNumber] = $data;
    }

    #[On('saveUser')]
    public function saveUser()
    {
        $allData = collect($this->formData)->collapse()->toArray();

        // dd($allData);

        $success = true; // Flag to track success

        $user = Auth::user();

        try {

            DB::beginTransaction();

            $imgtempPath = $allData['cimg'];

            // Define the new file name and path for storage
            $imgnewFileName = basename($imgtempPath);
            $imgfinalPath = 'images/user_data/' . $imgnewFileName;

            // Move the file to the final storage location
            Storage::disk('public')->move($imgtempPath, $imgfinalPath);

            $employer = Company::create([
                'user_id' => $user->id,
                'business_Name' => $allData['business'],
                'trade_Name' => $allData['trade'],
                'company_TIN' => $allData['tin'],
                'company_Type' => $allData['locType'],
                'employer_Type' => $allData['empType'],
                'employer_Type_Desc' => $allData['empDesc'],
                'company_Total_workforce' => $allData['workForce'],
                'company_Address' => $allData['address'],
                'barangay_id' => $allData['barangayID'],
                'contact_Person' => $allData['name'],
                'contact_Person_position' => $allData['position'],
                'company_Pnum' => $allData['phone'],
                'company_Tnum' => $allData['tel'],
                'company_Fnum' => $allData['fax'],
                'company_Email' => $allData['email'],
                'company_Status' => 'ACTIVE',
                'company_img' => $imgfinalPath,
            ]);

            if ($employer->company_id) {

                // ADDING INDUSTRY PREFERENCE
                foreach ($allData['industryData'] as $industryPref) {
                    Company_Industry_Line::create([
                        'company_id' => $employer->company_id, // Assuming 'employee_id' is the foreign key column
                        'industry_id' => $industryPref['industry_id'],
                    ]);
                }

                foreach ($allData['partnershipData'] as $partnership) {
                    Partnerships::create([
                        'company_id' => $employer->company_id, // Assuming 'employee_id' is the foreign key column
                        'peso_id' => $partnership['peso_id'],
                    ]);
                }

                foreach ($allData['reqData'] as $reqData) {
                    // Get the temporary file path
                    $tempPath = $reqData['temp_path'];
                    $requirementId = $reqData['requirement_id'];

                    // Define the new file name and path for storage
                    $newFileName = basename($tempPath);
                    $finalPath = 'requirements/' . $newFileName;

                    // Move the file to the final storage location
                    Storage::disk('public')->move($tempPath, $finalPath);

                    // Create a database record with the stored path
                    Requirements_Passed::create([
                        'company_id' => $employer->company_id, // Replace with actual job ID
                        'requirement_id' => $requirementId,
                        'req_passed_Input' => $finalPath,
                    ]);
                }

                // ADD LANGUAGE PREFERENCE

                $user = Auth::user();
                $user->userType = '5';

                /** @var \App\Models\User $user **/
                $user->save();
                // Update the user's role

                DB::commit();

            }

        } catch (\Exception $e) {
            DB::rollback();
            $success = false;

            if (Storage::disk('public')->exists($imgfinalPath)) {
                Storage::disk('public')->delete($imgfinalPath);
            }
            foreach ($allData['reqData'] as $reqData) {
                $tempPath = $reqData['temp_path'];
                // Check if the file exists and delete it
                if (Storage::disk('public')->exists($tempPath)) {
                    Storage::disk('public')->delete($tempPath);
                }
            }

            // dd($e->getMessage());
            Log::error('Error registering employer: ' . $e->getMessage());

            toastr()->error('Error in updating user details, please try again later');

        }

        if ($success) {
            Mail::to($employer->user->email)->queue(new WelcomeCompany($employer));

            redirect()->route('dashboard');
            return toastr()->success('Account Successfully Updated, Please check your email for more information.');

        }

    }

    #[On('nextStep')]
    public function nextStep($id)
    {
        $this->currentStep = $id;
    }

    #[On('prevStep')]
    public function prevStep($id)
    {
        $this->currentStep = $id;
    }

    public function render()
    {
        return view('livewire.signup.employer.employer-information');
    }
}
