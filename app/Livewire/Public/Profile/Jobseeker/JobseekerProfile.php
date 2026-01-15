<?php

namespace App\Livewire\Public\Profile\Jobseeker;

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class JobseekerProfile extends Component
{

    public $id;
    public $description;
    // public $successss = false;

    public function rules()
    {
        return [
            'description' => ['required', 'string', 'min:50', 'max:1000'],

        ];
    }

    public function mount()
    {
        $employeeInfo = Employee::find($this->id);

        if (!$employeeInfo || $employeeInfo->user->usertype != 4 || $employeeInfo->user->userstatus != 1) {
            return $this->redirectRoute('dashboard');
        }

    }

    public function viewFile($id, $fileToView)
    {

        $this->dispatch('viewFile', [
            'url' => route('view.resume'),
            'emp_id' => $id,
            'resume_type' => $fileToView,
        ]);

    }

    public function editModal()
    {
        $this->resetValidation();
        $employeeInfo = Employee::find($this->id);
        $this->description = $employeeInfo->empDesc;

        $this->dispatch('open-modal', 'aboutme-modal');
    }

    public function save()
    {
        $this->validate();

        try {
            Employee::where('employee_id', $this->id)->update([
                'empDesc' => $this->description,
            ]);
            toastr()->success('About Me Record has been Updated!');

            $this->close();
            // $this->dispatch('reload-table');
        } catch (\Exception $e) {
            toastr()->error('There was an Error');
        }
    }

    public function close()
    {
        // dump($this->id);

        $this->reset('description');
        $this->dispatch('close-modal', 'aboutme-modal');
    }

    #[On('reload-table')]
    public function render()
    {

        $highestEduTitle = 'None';
        $isOwner = false;

        $user = Auth::user();

        if ($user->usertype == 4) {
            if ($user->employee->employee_id == $this->id) {
                $isOwner = true;
            }
        }

        $jobseeker = Employee::with([
            'education' => function ($query) {
                $query->orderBy('edu_Started', 'desc');
            },
            'work_exp' => function ($query) {
                $query->orderBy('work_Start', 'desc');
            },
            'certificate' => function ($query) {
                $query->orderBy('cert_Date_Issued', 'desc');
            },
            'training' => function ($query) {
                $query->orderBy('training_Start', 'desc');
            },
            'language' => function ($query) {
                $query->pluck('language_Type');
            },
            'disability' => function ($query) {
                $query->pluck('disability_Type');
            },
            // 'eligibility' => function ($query) {
            //     $query->orderBy('eligibility_Date', 'desc');
            // }
        ])->find($this->id);

        if ($jobseeker) {
            $eduLevels = [
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
            if ($jobseeker->education->isNotEmpty()) {
                // Retrieve the highest education level
                $highestEduLevel = $jobseeker->education->sortByDesc('edu_Level')->first()->edu_Level;

                // Get the corresponding education title
                $highestEduTitle = $eduLevels[$highestEduLevel] ?? 'Unknown';
            }
        }

        return view('livewire.public.profile.jobseeker.jobseeker-profile', compact('jobseeker', 'highestEduTitle', 'isOwner'));
    }
}
