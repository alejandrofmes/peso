<?php

namespace App\Livewire\Signup\Jobseeker;

use App\Models\Certificate;
use App\Models\Disability;
use App\Models\Education;
use App\Models\Eligibility;
use App\Models\Employee;
use App\Models\Industry_preference;
use App\Models\Job_Preference;
use App\Models\Language;
use App\Models\License;
use App\Models\Skills;
use App\Models\Training;
use App\Models\Work_Exp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.empty')]
class JobseekerInformation extends Component
{
    use WithFileUploads;

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

        $success = true; // Flag to track success

        $user = Auth::user();

        try {

            DB::beginTransaction();

            $imgtempPath = $allData['pimage'];

            // Define the new file name and path for storage
            $imgnewFileName = basename($imgtempPath);
            $imgfinalPath = 'images/user_data/' . $imgnewFileName;

            // Move the file to the final storage location
            Storage::disk('public')->move($imgtempPath, $imgfinalPath);

            $employee = Employee::create([
                'user_id' => $user->id,
                'fname' => $allData['fname'],
                'mname' => $allData['mname'],
                'lname' => $allData['lname'],
                'suffix' => $allData['suffix'],
                'height' => $allData['height'],
                'gender' => $allData['gender'],
                'civilstatus' => $allData['civilstatus'],
                'religion' => $allData['religion'],
                'birthdate' => $allData['bday'],
                'pnumber' => $allData['phone'],
                'address' => $allData['address'],
                'barangay_id' => $allData['barangayID'],
                'tinnum' => $allData['tin'],
                'empstatus' => $allData['empStatus'],
                'empstatusdesc' => $allData['empDescription'],
                'ofw' => $allData['ofw'],
                'fourp' => $allData['fourP'],
                'fourpID' => $allData['fourPID'],
                'empprofile' => $allData['privacySetting'],
                'pimg' => $imgfinalPath,
            ]);

            if ($employee->employee_id) {

                // ADDING DISABILITY
                if (!empty($allData['otherDisability'])) {
                    $allData['disabilityBox'][] = $allData['otherDisability'];
                }
                foreach ($allData['disabilityBox'] as $disabilityType) {
                    Disability::create([
                        'employee_id' => $employee->employee_id,
                        'disability_Type' => $disabilityType,
                    ]);
                }

                // ADDING JOB PREFERENCE
                foreach ($allData['jobpreference'] as $jobPref) {
                    Job_Preference::create([
                        'employee_id' => $employee->employee_id, // Assuming 'employee_id' is the foreign key column
                        'position_id' => $jobPref['position_id'],
                    ]);
                }

                // ADDING INDUSTRY PREFERENCE
                foreach ($allData['industrypreference'] as $industryPref) {
                    Industry_preference::create([
                        'employee_id' => $employee->employee_id, // Assuming 'employee_id' is the foreign key column
                        'industry_id' => $industryPref['industry_id'],
                    ]);
                }

                // ADD LANGUAGE PREFERENCE
                foreach ($allData['languages'] as $language) {
                    $read = $language['read'] ? 1 : 2; // Convert true to 1 and false to 2
                    $write = $language['write'] ? 1 : 2;
                    $speak = $language['speak'] ? 1 : 2;
                    $understand = $language['understand'] ? 1 : 2;

                    Language::create([
                        'employee_id' => $employee->employee_id,
                        'language_Type' => $language['language'],
                        'language_Read' => $read,
                        'language_Write' => $write,
                        'language_Speak' => $speak,
                        'language_Understand' => $understand,
                    ]);
                }

                // ADD EDUCATION
                foreach ($allData['educationData'] as $educationData) {
                    $ongoing = $educationData['eduOngoing'] ? 1 : 2; // Convert true to 1 and false to 2

                    Education::create([
                        'employee_id' => $employee->employee_id,
                        'edu_School' => $educationData['eduSchool'],
                        'edu_Level' => $educationData['eduLevel'],
                        'edu_Course' => $educationData['eduCourse'],
                        'edu_Started' => date('Y-m-d', strtotime($educationData['eduStart'])),
                        'edu_Ended' => is_null($educationData['eduEnd']) ? null : date('Y-m-d', strtotime($educationData['eduEnd'])),
                        'edu_Ongoing' => $ongoing,
                    ]);
                }

                // CERTIFICATE
                foreach ($allData['certificateData'] as $certificateData) {
                    Certificate::create([
                        'employee_id' => $employee->employee_id,
                        'cert_Type_id' => $certificateData['certTypeID'],
                        'cert_From' => $certificateData['certFrom'],
                        'cert_Date_Issued' => date('Y-m-d', strtotime($certificateData['certEarned'])),
                        'cert_Rating' => $certificateData['certRate'],
                    ]);
                }

                // TRAINING
                foreach ($allData['trainingData'] as $trainingData) {
                    Training::create([
                        'employee_id' => $employee->employee_id,
                        'training_Name' => $trainingData['trainName'],
                        'training_From' => $trainingData['trainInstitution'],
                        'training_Cert' => $trainingData['trainCert'],
                        'training_Start' => date('Y-m-d', strtotime($trainingData['trainStart'])),
                        'training_End' => is_null($trainingData['trainEnd']) ? null : date('Y-m-d', strtotime($trainingData['trainEnd'])),
                        'training_Status' => $trainingData['trainStat'],
                    ]);
                }

                // ELIGIBILITY
                foreach ($allData['eligibilityData'] as $eligibilityData) {
                    Eligibility::create([
                        'employee_id' => $employee->employee_id,
                        'eligibility_Type' => $eligibilityData['eligibilityId'],
                        'eligibility_Date' => date('Y-m-d', strtotime($eligibilityData['eligibilityDate'])),
                    ]);
                }

                // LICENSE
                foreach ($allData['licenseData'] as $licenseData) {
                    License::create([
                        'employee_id' => $employee->employee_id,
                        'license_type_id' => $licenseData['licenseId'],
                        'license_Validity' => date('Y-m-d', strtotime($licenseData['licenseDate'])),
                    ]);
                }

                // WORK EXPERIENCE
                foreach ($allData['workExperienceData'] as $workExperienceData) {
                    Work_Exp::create([
                        'employee_id' => $employee->employee_id,
                        'work_Name' => $workExperienceData['workEmp'],
                        'work_Address' => $workExperienceData['workAdd'],
                        'position_id' => $workExperienceData['workPositionId'],
                        'work_Start' => date('Y-m-d', strtotime($workExperienceData['workStart'])),
                        'work_End' => is_null($workExperienceData['workEnd']) ? null : date('Y-m-d', strtotime($workExperienceData['workEnd'])),
                        'work_Status' => $workExperienceData['workStatus'],
                    ]);
                }

                // OTHER SKILLS
                foreach ($allData['otherSkills'] as $otherSkills) {
                    Skills::create([
                        'employee_id' => $employee->employee_id,
                        'skill_Type' => $otherSkills,
                    ]);
                }

                $user = Auth::user();
                $user->userType = '4';

                /** @var \App\Models\User $user **/
                $user->save();
                // Update the user's role

                DB::commit();
            }

        } catch (\Exception $e) {
            DB::rollback();
            $success = false;
            // dd($e->getMessage());
            Log::error('Error registering employee: ' . $e->getMessage());
            toastr()->error('Error in updating user details, please try again later');

        }

        if ($success) {

            redirect()->route('dashboard');

            return toastr()->success('Account Successfully Updated!');
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
        return view('livewire.signup.jobseeker.jobseeker-information');
    }
}
