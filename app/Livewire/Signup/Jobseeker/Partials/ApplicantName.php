<?php

namespace App\Livewire\Signup\Jobseeker\Partials;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ApplicantName extends Component
{
    use WithFileUploads;

    public $stepNumber = 1;

    public $fname, $mname, $lname, $suffix = "", $bday, $gender = "";

    #[Validate]
    public $pimage;

    public function rules()
    {
        return [
            'pimage' => 'required|image|mimes:jpeg,png,jpg',
        ];
    }

    public function messages()
    {
        return [
            'pimage.required' => 'The image is required.',
            'pimage.image' => 'The uploaded file must be an image.',
            'pimage.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            // 'pimage.max' => 'The image may not be greater than 15MB.',
        ];
    }
    public function next()
    {
        $rules = [
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'bday' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'), // Ensures the date is not today or any future date
            ],
            'gender' => 'required|in:1,2', // Assuming gender can only be Male or Female
            'pimage' => 'required|image|mimes:jpeg,png,jpg', // Required image, max 5MB, allowed types: jpeg, png, jpg
        ];
        $messages = [
            'fname.required' => 'First name is required.',
            'fname.string' => 'First name must be a string.',
            'fname.max' => 'First name may not be greater than 255 characters.',
            'mname.string' => 'Middle name must be a string.',
            'mname.max' => 'Middle name may not be greater than 255 characters.',
            'lname.required' => 'Last name is required.',
            'lname.string' => 'Last name must be a string.',
            'lname.max' => 'Last name may not be greater than 255 characters.',
            'suffix.string' => 'Suffix must be a string.',
            'suffix.max' => 'Suffix may not be greater than 10 characters.',
            'bday.required' => 'Birthdate is required.',
            'bday.date' => 'Birthdate must be a valid date.',
            'bday.before_or_equal' => 'You must be at least 15 years old.',
            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be either Male or Female.',
            'pimage.required' => 'Profile image is required.',
            'pimage.image' => 'Uploaded file must be an image.',
            'pimage.mimes' => 'Only JPEG, PNG, and JPG formats are allowed for images.',
            // 'pimage.max' => 'Uploaded image may not be greater than 15MB.',
        ];

        $this->validate($rules, $messages);

        $imgPath = $this->pimage->store('temp/user_data', 'public');

        $this->dispatch('handleStepData', $this->stepNumber, [
            'fname' => ucwords(strtolower($this->fname)),
            'mname' => ucwords(strtolower($this->mname)),
            'lname' => ucwords(strtolower($this->lname)),
            'suffix' => $this->suffix,
            'bday' => $this->bday,
            'gender' => $this->gender,
            'pimage' => $imgPath,
        ]);
        $this->dispatch('nextStep', $this->stepNumber + 1);
    }

    // public function prev()
    // {
    //     $this->dispatch('prevStep', $this->stepNumber - 1);
    // }

    public function render()
    {
        return view('livewire.signup.jobseeker.partials.applicant-name');
    }
}
