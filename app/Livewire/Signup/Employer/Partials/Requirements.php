<?php

namespace App\Livewire\Signup\Employer\Partials;

use App\Models\Requirements as ModelsRequirements;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;

class Requirements extends Component
{

    use WithFileUploads;

    public $req = [];

    #[Reactive]
    public $reqType;

    public $stepNumber = 4;

    public function mount()
    {
        // Fetch all requirements
        $requirements = ModelsRequirements::where('requirement_Status', 1)
            ->where('requirement_Type', $this->reqType)->get();
        // Initialize the $req array with requirement IDs
        foreach ($requirements as $requirement) {
            $this->req[$requirement->requirement_id] = null;
        }
    }

    public function next()
    {
        $validationRules = [];
        $reqData = [];

        // foreach ($this->req as $requirementId => $file) {
        //     $validationRules['req.' . $requirementId] = 'mimes:pdf';
        // }

        // $this->validate($validationRules);
        $rules = [
            'req.*' => 'required|file|mimes:pdf|max:15360', // Max size 5MB, PDF only
        ];

        $messages = [
            'req.*.mimes' => 'Uploaded file must be a PDF.',
            'req.*.max' => 'Uploaded file must be under 15MB.',
            'req.*.required' => 'File is required.',

        ];

        $this->validate($rules, $messages);

        foreach ($this->req as $requirementId => $file) {
            if ($file) {
                // Store the file temporarily

                $tempPath = $file->store('temp/requirements', 'public');

                $reqData[] = [
                    'requirement_id' => $requirementId,
                    'temp_path' => $tempPath,
                ];
            }
        }

        $this->dispatch('handleStepData', $this->stepNumber, [
            'reqData' => $reqData,

        ]);

        $this->dispatch('nextStep', $this->stepNumber + 1);

    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);

    }

    public function render()
    {

        $requirements = ModelsRequirements::where('requirement_Status', 1)
            ->where('requirement_Type', $this->reqType)->get();

        return view('livewire.signup.employer.partials.requirements', compact('requirements'));
    }
}
