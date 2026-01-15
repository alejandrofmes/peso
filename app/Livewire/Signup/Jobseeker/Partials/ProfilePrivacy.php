<?php

namespace App\Livewire\Signup\Jobseeker\Partials;

use Livewire\Component;

class ProfilePrivacy extends Component
{

    public $stepNumber = 11;

    public $privacy = 1;

    public function next()
    {

        $rules = [
            'privacy' => ['required'],
        ];

        $messages = [
            'privacy.required' => 'The privacy option is required.',
        ];

        $this->validate($rules, $messages);

        $this->dispatch('handleStepData', $this->stepNumber, [
            'privacySetting' => $this->privacy,
        ]);

        $this->dispatch('nextStep', $this->stepNumber + 1);
    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);
    }

    public function render()
    {
        return view('livewire.signup.jobseeker.partials.profile-privacy');
    }
}
