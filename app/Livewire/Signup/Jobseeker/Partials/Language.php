<?php

namespace App\Livewire\Signup\Jobseeker\Partials;

use Livewire\Attributes\On;
use Livewire\Component;

class Language extends Component
{

    public $languages = [];
    public $languageError = '';

    public $stepNumber = 5;

    public function removeLanguage($index)
    {
        unset($this->languages[$index]);
        $this->languages = array_values($this->languages);

    }

    public function next()
    {
        $this->validate([
            'languages' => 'required|array|min:1',
        ]);

        $this->dispatch('handleStepData', $this->stepNumber, [
            'languages' => $this->languages,
        ]);
        $this->dispatch('nextStep', $this->stepNumber + 1);
    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);
    }

    #[On('refreshLanguage')]
    public function render()
    {
        return view('livewire.signup.jobseeker.partials.language');
    }
}
