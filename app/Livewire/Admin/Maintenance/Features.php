<?php

namespace App\Livewire\Admin\Maintenance;

use App\Models\Experimental_Features;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Features extends Component
{

    public $crossJob, $crossProgram;

    public $password;
    public function validateAction($type)
    {

        if ($type == 1) {
            if ($this->crossJob == false) {
                $this->dispatch('open-modal', 'crossjob-enable');
            } else {
                $this->dispatch('open-modal', 'crossjob-disable');

            }
        }
        if ($type == 2) {
            if ($this->crossProgram == false) {
                $this->dispatch('open-modal', 'crossprogram-enable');
            } else {
                $this->dispatch('open-modal', 'crossprogram-disable');

            }
        }
    }

    public function confirmResponse($type, $value, $modal)
    {
        $rules = [
            'password' => 'required|string|min:6',
        ];

        $messages = [
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 6 characters.',
        ];

        $this->validate($rules, $messages);

        if (!Hash::check($this->password, Auth::user()->password)) {
            // Use Laravel's validation system to return error messages
            $this->reset('password');
            return $this->addError('password', 'The provided password is incorrect.');

        } else {

            $this->updateFeature($type, $value, $modal);

        }

    }

    public function updateFeature($id, $value, $modal)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the feature by its ID
            $feature = Experimental_Features::find($id);

            // Update the feature status
            $feature->update([
                'feature_Status' => $value,
            ]);

            // Commit the transaction
            DB::commit();

            // Optionally return success response or message
            toastr()->success('Feature successfully updated.');
            $this->closeModal($modal);

        } catch (\Exception $e) {
            // Rollback the transaction if there was an error
            DB::rollBack();

            // Log the error or handle it as necessary
            Log::error('Failed to update feature: ' . $e->getMessage());

            // Optionally return error response
            toastr()->error('There was an error updating the feature.');
            $this->closeModal($modal);

        }
    }

    public function closeModal($modal)
    {
        $this->reset('password');
        $this->resetExcept('crossJob', 'crossProgram');
        $this->dispatch('close-modal', $modal);
        $this->resetValidation();

    }

    public function getCrossJob()
    {

        $features = Experimental_Features::find(1);

        if ($features) {

            if ($features->feature_Status == 'enabled') {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function getCrossProgram()
    {

        $features = Experimental_Features::find(2);

        if ($features) {

            if ($features->feature_Status == 'enabled') {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function testBut()
    {
        dd($this->crossJob);
    }

    public function render()
    {

        $this->crossJob = $this->getCrossJob();
        $this->crossProgram = $this->getCrossProgram();

        return view('livewire.admin.maintenance.features');
    }
}
