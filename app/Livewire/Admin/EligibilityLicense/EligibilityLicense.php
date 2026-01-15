<?php

namespace App\Livewire\Admin\EligibilityLicense;

use App\Models\Eligibility_Type;
use App\Models\License_Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class EligibilityLicense extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $rows = 10;

    public $searchEligiblity, $searchLicense;

    public $eligibilityPost, $ecodePost, $eligibilityID;

    public $licensePost, $lcodePost, $licenseID;

    public $archiveEli, $archiveLic;
    public $restoreEli, $restoreLic;

    public $filterEligibility = 'All', $filterLicense = 'All';

    public function updatedsearchEligiblity()
    {
        $this->resetPage('eligibility'); // Reset pagination for eligibility search
    }

    // Listen for updates to the searchLicense variable
    public function updatedsearchLicense()
    {
        $this->resetPage('license'); // Reset pagination for license search
    }

    public function updateFilter($type, $value)
    {
        if ($type == 1) {
            $this->filterEligibility = $value;
            $this->resetPage('eligibility'); // Reset pagination for eligibility search

        } elseif ($type == 2) {
            $this->filterLicense = $value;
            $this->resetPage('license'); // Reset pagination for license search

        }
    }
    public function archiveConfirmation($type, $id)
    {
        $this->reset('archiveEli', 'archiveLic');
        if ($type == 1) {
            $this->archiveEli = $id;
            $this->dispatch('open-modal', 'delete-eligibility-modal');

        } elseif ($type == 2) {
            $this->archiveLic = $id;
            $this->dispatch('open-modal', 'delete-license-modal');

        } else {
            toastr()->error('There was an error. Please try again later.');
        }
    }

    public function confirmArchive($type)
    {
        DB::beginTransaction();

        try {
            if ($type == 1) {
                $eligibility = Eligibility_Type::findOrFail($this->archiveEli);
                $eligibility->eligibility_Status = 2;
                $eligibility->save();

                $this->dispatch('close-modal', 'delete-eligibility-modal');
                toastr()->success('Eligibility Type was successfully archived!');
            } elseif ($type == 2) {
                $license = License_Type::findOrFail($this->archiveLic);
                $license->license_Status = 2;
                $license->save();

                $this->dispatch('close-modal', 'delete-license-modal');
                toastr()->success('License Type was successfully archived!');
            } else {
                toastr()->error('Invalid archive type. Please try again.');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('There was an error. Please try again later.');
            // Log the exception if necessary
            Log::error('Error archiving: ' . $e->getMessage());
        }
        $this->reset('archiveEli', 'archiveLic');

    }

    public function restoreConfirmation($type, $id)
    {
        $this->reset('restoreEli', 'restoreLic');
        if ($type == 1) {
            $this->restoreEli = $id;
            $this->dispatch('open-modal', 'restore-eligibility-modal');

        } elseif ($type == 2) {
            $this->restoreLic = $id;
            $this->dispatch('open-modal', 'restore-license-modal');

        } else {
            toastr()->error('There was an error. Please try again later.');
        }
    }

    public function confirmRestore($type)
    {
        DB::beginTransaction();

        try {
            if ($type == 1) {
                $eligibility = Eligibility_Type::findOrFail($this->restoreEli);
                $eligibility->eligibility_Status = 1;
                $eligibility->save();

                $this->dispatch('close-modal', 'restore-eligibility-modal');
                toastr()->success('Eligibility Type was successfully restored!');
            } elseif ($type == 2) {
                $license = License_Type::findOrFail($this->restoreLic);
                $license->license_Status = 1;
                $license->save();

                $this->dispatch('close-modal', 'restore-license-modal');
                toastr()->success('License Type was successfully restored!');
            } else {
                toastr()->error('Invalid restore type. Please try again.');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('There was an error. Please try again later.');
            // Log the exception if necessary
            Log::error('Error archiving: ' . $e->getMessage());
        }
        $this->reset('restoreEli', 'restoreLic');

    }

    public function saveEligibility()
    {

        if ($this->eligibilityID) {
            $rules = [
                'eligibilityID' => ['required'],
                'eligibilityPost' => ['required', 'string', Rule::unique('eligibility_type', 'eligibility_Name')->ignore($this->eligibilityID, 'eligibility_type_id')],
                'ecodePost' => ['required', 'string', Rule::unique('eligibility_type', 'eligibility_Code')->ignore($this->eligibilityID, 'eligibility_type_id')],
            ];

            $messages = [
                'eligibilityID.required' => 'The eligiblity ID is required.',
                'eligibilityPost.required' => 'The eligiblity title is required.',
                'eligibilityPost.string' => 'The eligiblity title must be a string.',
                'eligibilityPost.unique' => 'The eligiblity title has already been taken.',
                'ecodePost.required' => 'The eligiblity code is required.',
                'ecodePost.string' => 'The eligiblity code must be a string.',
                'ecodePost.unique' => 'The eligiblity code has already been taken.',
            ];

            $this->validate($rules, $messages);
            DB::beginTransaction();

            try {
                $eligibility_type = Eligibility_Type::findOrFail($this->eligibilityID);

                $eligibility_type->eligibility_Name = strtoupper($this->eligibilityPost);
                $eligibility_type->eligibility_Code = strtoupper($this->ecodePost);
                if ($eligibility_type->isDirty()) {
                    $eligibility_type->save();
                    toastr()->success('Eligibility has been updated!');
                } else {
                    toastr()->info('No changes detected.');
                }
                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error('There was an error updating the job position.');
            }
        } else {
            $rules = [
                'eligibilityPost' => ['required', 'string', Rule::unique('eligibility_type', 'eligibility_Name')],
                'ecodePost' => ['required', 'string', Rule::unique('eligibility_type', 'eligibility_Code')],
            ];

            $messages = [
                'eligibilityPost.required' => 'The eligiblity title is required.',
                'eligibilityPost.string' => 'The eligiblity title must be a string.',
                'eligibilityPost.unique' => 'The eligiblity title has already been taken.',
                'ecodePost.required' => 'The eligiblity code is required.',
                'ecodePost.string' => 'The eligiblity code must be a string.',
                'ecodePost.unique' => 'The eligiblity code has already been taken.',
            ];

            $this->validate($rules, $messages);
            DB::beginTransaction();
            try {
                Eligibility_Type::create([
                    'eligibility_Name' => strtoupper($this->eligibilityPost),
                    'eligibility_Code' => strtoupper($this->ecodePost),
                ]);
                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error('There was an error updating the eligibility record.');
            }
            toastr()->success('Eligibility Created!');
        }

        $this->close('eligibility');

    }

    public function editEligibility($id)
    {

        $eligibility = Eligibility_Type::findOrFail($id);

        if ($eligibility) {
            $this->eligibilityID = $eligibility->eligibility_type_id;
            $this->eligibilityPost = $eligibility->eligibility_Name;
            $this->ecodePost = $eligibility->eligibility_Code;
            $this->dispatch('open-modal', 'eligibility-modal');
        } else {
            toastr()->error('There was an error in finding the data.');
        }
    }

    public function saveLicense()
    {

        if ($this->licenseID) {
            $rules = [
                'licenseID' => ['required'],
                'licensePost' => ['required', 'string', Rule::unique('license_type', 'license_Name')->ignore($this->licenseID, 'license_type_id')],
                'lcodePost' => ['required', 'string', Rule::unique('license_type', 'license_Code')->ignore($this->licenseID, 'license_type_id')],
            ];

            $messages = [
                'licenseID.required' => 'The license ID is required.',
                'licensePost.required' => 'The license title is required.',
                'licensePost.string' => 'The license title must be a string.',
                'licensePost.unique' => 'The license title has already been taken.',
                'lcodePost.required' => 'The license code is required.',
                'lcodePost.string' => 'The license code must be a string.',
                'lcodePost.unique' => 'The license code has already been taken.',

            ];

            $this->validate($rules, $messages);
            DB::beginTransaction();

            try {
                $license = License_Type::findOrFail($this->licenseID);

                $license->license_Name = strtoupper($this->licensePost);
                $license->license_Code = strtoupper($this->lcodePost);
                if ($license->isDirty()) {
                    $license->save();
                    toastr()->success('License has been updated!');
                } else {
                    toastr()->info('No changes detected.');
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error('There was an error updating the license.');
            }
        } else {
            $rules = [
                'licensePost' => ['required', 'string', Rule::unique('license_type', 'license_Name')],
                'lcodePost' => ['required', 'string', Rule::unique('license_type', 'license_Code')],
            ];

            $messages = [
                'licenseID.required' => 'The license ID is required.',
                'licensePost.required' => 'The license title is required.',
                'licensePost.string' => 'The license title must be a string.',
                'licensePost.unique' => 'The license title has already been taken.',
                'lcodePost.required' => 'The license code is required.',
                'lcodePost.string' => 'The license code must be a string.',
                'lcodePost.unique' => 'The license code has already been taken.',
            ];

            $this->validate($rules, $messages);
            DB::beginTransaction();

            try {
                License_Type::create([
                    'license_Name' => strtoupper($this->licensePost),
                    'license_Code' => strtoupper($this->lcodePost), // Validate role selection
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error('There was an error updating the license.');
            }

            toastr()->success('License Created!');
        }
        $this->close('license');

    }

    public function editLicense($id)
    {
        $license = License_Type::findOrFail($id);

        if ($license) {
            $this->licenseID = $license->license_type_id;
            $this->licensePost = $license->license_Name;
            $this->lcodePost = $license->license_Code;
            $this->dispatch('open-modal', 'license-modal');
        } else {
            toastr()->error('There was an error in finding the data.');
        }
    }

    public function open($modal)
    {
        $this->resetExcept('searchEligiblity', 'searchLicense', 'rows');
        $this->resetValidation();
        $this->dispatch('open-modal', $modal . '-modal');

    }

    public function close($modal)
    {
        $this->dispatch('close-modal', $modal . '-modal');
        $this->resetExcept('searchEligiblity', 'searchLicense', 'rows');
        $this->resetValidation();
    }

    public function render()
    {
        $eligibilityQuery = Eligibility_Type::where('eligibility_Name', 'like', '%' . $this->searchEligiblity . '%')
            ->orderBy('eligibility_Name', 'asc');

        $licenseQuery = License_Type::where('license_Name', 'like', '%' . $this->searchLicense . '%')
            ->orderBy('license_Name', 'asc');

        if ($this->filterEligibility == 'All') {
            $eligibilityQuery->where('eligibility_Status', 1);
        } else if ($this->filterEligibility == 'Archived') {
            $eligibilityQuery->where('eligibility_Status', 2);
        }

        if ($this->filterLicense == 'All') {
            $licenseQuery->where('license_Status', 1);
        } else if ($this->filterLicense == 'Archived') {
            $licenseQuery->where('license_Status', 2);
        }

        // Paginate eligibility query
        $eligibility = $eligibilityQuery ->orderBy('eligibility_Name', 'asc')->paginate($this->rows, ['*'], 'eligibility');

// Paginate license query
        $license = $licenseQuery ->orderBy('license_Name', 'asc')->paginate($this->rows, ['*'], 'license');

        return view('livewire.admin.eligibility-license.eligibility-license', compact('eligibility', 'license'));
    }
}
