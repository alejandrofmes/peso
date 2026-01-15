<?php

namespace App\Livewire\Signup\Employer\Partials;

use App\Models\Barangay;
use App\Models\Job_Industry;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompanyInformation extends Component
{

    use WithFileUploads;

    public $tin, $business, $trade, $locType = "", $workForce = "", $empType = "", $empDesc = "", $address, $barangayID;

    #[Validate]
    public $cimg;

    public $industryData = [];

    public $mun, $prov, $bar;

    public $stepNumber = 1;

    public function rules()
    {
        return [
            'cimg' => 'required|image|mimes:jpeg,png,jpg',
        ];
    }
    public function messages()
    {
        return [
            'cimg.required' => 'The image is required.',
            'cimg.image' => 'The uploaded file must be an image.',
            'cimg.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            // 'cimg.max' => 'The image may not be greater than 15MB.',
        ];
    }

    #[On('barSelect')]
    public function barSelect($id)
    {
        $barangay = Barangay::findOrFail($id);

        if ($barangay) {
            $this->barangayID = $id;
            $this->bar = $barangay->barangay_Name;
            $this->mun = $barangay->municipality->municipality_Name;
            $this->prov = $barangay->municipality->province->province_Name;

        }

    }

    #[On('industrySelect')]
    public function industrySelect($id)
    { // Check if the selected job position already exists in the $jobTags array
        if (collect($this->industryData)->contains('industry_id', $id)) {
            toastr()->warning('This industry is already selected.');
            return;
        }

        if (count($this->industryData) >= 1) {
            toastr()->warning('You can only choose one industry.');
            $this->dispatch('close-modal', 'industry-modal');
            return;
        }

        // If the job position does not exist in the array, add it
        $industry = Job_Industry::find($id);

        if ($industry) {
            $this->industryData[] = [
                'industry_id' => $industry->industry_id,
                'industry_Title' => $industry->industry_Title,
            ];
            $this->dispatch('close-modal', 'industry-modal');
        } else {
            toastr()->error('Could not fetch data');
            $this->dispatch('close-modal', 'industry-modal');
        }

    }
    public function removeIndustry($industryId)
    {
        // Find the index of the element with the given position_id
        $index = array_search($industryId, array_column($this->industryData, 'industry_id'));

        // If the element exists in the array, remove it
        if ($index !== false) {
            unset($this->industryData[$index]);
            // Reindex the array to maintain sequential keys
            $this->industryData = array_values($this->industryData);
        }
    }

    public function next()
    {
        $rules = [
            'tin' => 'required_if:empType,2|digits:9|unique:company,company_TIN',
            'business' => 'required|string|min:5|unique:company,business_Name',
            'trade' => 'required|string|min:5|unique:company,trade_Name',
            'locType' => 'required',
            'workForce' => 'required',
            'empType' => 'required',
            'empDesc' => 'required',
            'address' => 'required|string|min:5',
            'barangayID' => 'required',
            'industryData' => 'required|array|min:1',
            'cimg' => 'required|image|mimes:jpeg,png,jpg',
        ];

        $messages = [
            'tin.required_if' => 'The TIN is required for private employers.',
            'tin.digits' => 'TIN must have 9 characters.',
            'tin.unique' => 'The TIN has already been taken.',

            'business.required' => 'The business name is required.',
            'business.string' => 'The business name must be a string.',
            'business.min' => 'The business name must be at least 5 characters.',
            'business.unique' => 'The business name has already been taken.',

            'trade.required' => 'The trade name is required.',
            'trade.string' => 'The trade name must be a string.',
            'trade.min' => 'The trade name must be at least 5 characters.',
            'trade.unique' => 'The trade name has already been taken.',

            'locType.required' => 'The location type is required.',

            'workForce.required' => 'The workforce is required.',

            'empType.required' => 'The employment type is required.',

            'empDesc.required' => 'The employment description is required.',

            'address.required' => 'The address is required.',
            'address.string' => 'The address must be a string.',
            'address.min' => 'The address must be at least 5 characters.',

            'barangayID.required' => 'Barangay is required.',

            'industryData.required' => 'The industry line must have at least 1 item.',
            'industryData.array' => 'The industry data must be an array.',
            'industryData.min' => 'The industry line must have at least 1 item.',

            'cimg.required' => 'The image is required.',
            'cimg.image' => 'The uploaded file must be an image.',
            'cimg.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            // 'cimg.max' => 'The image may not be greater than 15MB.',
        ];

        $this->validate($rules, $messages);

        $imgPath = $this->cimg->store('temp/user_img', 'public');

        $this->dispatch('handleStepData', $this->stepNumber, [
            'business' => $this->business,
            'trade' => $this->trade,
            'tin' => $this->tin,
            'locType' => $this->locType,
            'workForce' => $this->workForce,
            'empType' => $this->empType,
            'empDesc' => $this->empDesc,
            'address' => $this->address,
            'barangayID' => $this->barangayID,
            'cimg' => $imgPath,
            'industryData' => $this->industryData,

        ]);
        $this->dispatch('nextStep', $this->stepNumber + 1);

    }

    public function render()
    {
        return view('livewire.signup.employer.partials.company-information');
    }
}
