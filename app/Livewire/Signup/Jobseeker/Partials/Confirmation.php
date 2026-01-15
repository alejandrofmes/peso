<?php

namespace App\Livewire\Signup\Jobseeker\Partials;

use Livewire\Component;

class Confirmation extends Component
{

    public $agreeBox = false;
    public $stepNumber = 12;

    public function save()
    {
        $this->dispatch('saveUser');
    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);
        $this->agreeBox = false;
    }
    public function render()
    {
        return view('livewire.signup.jobseeker.partials.confirmation');
    }
}
