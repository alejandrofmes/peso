<?php

namespace App\Livewire\Signup\Employer\Partials;

use Livewire\Component;

class ContactInformation extends Component
{

    public $name, $phone, $tel, $fax, $email, $position;

    public $stepNumber = 2;

    public function next()
    {
        $rules = [
            'name' => 'required|string|min:5',
            'phone' => 'required|regex:/^09\d{9}$/',
            'tel' => 'nullable|numeric',
            'fax' => 'nullable|numeric',
            'email' => 'required|email',
            'position' => 'required|string',
        ];

        $messages = [
            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a valid string.',
            'name.min' => 'The name must be at least 5 characters long.',

            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'The phone number must start with 09 and be exactly 11 digits long.',

            // 'tel.required' => 'The telephone number is required.',
            // 'tel.regex' => 'The telephone number must be a valid number.',
            'tel.numeric' => 'The telephone number must be exactly 7 digits long.',


            // 'fax.required' => 'The fax number is required.',
            // 'fax.regex' => 'The fax number must be a valid number.',
            'fax.numeric' => 'The fax number must be exactly 7 digits long.',


            'email.required' => 'The email address is required.',
            'email.email' => 'The email address must be a valid email address.',

            'position.required' => 'The position is required.',
            'position.string' => 'The position must be a valid string.',
        ];

        $this->validate($rules, $messages);

        $this->dispatch('handleStepData', $this->stepNumber, [
            'name' => $this->name,
            'phone' => $this->phone,
            'tel' => $this->tel,
            'fax' => $this->fax,
            'email' => $this->email,
            'position' => $this->position,
        ]);

        $this->dispatch('nextStep', $this->stepNumber + 1);

    }

    public function prev()
    {
        $this->dispatch('prevStep', $this->stepNumber - 1);
    }

    public function render()
    {
        return view('livewire.signup.employer.partials.contact-information');
    }
}
