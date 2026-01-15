<?php

namespace App\Livewire\Public\Profile\Jobseeker\Partials;

use App\Models\Certificate;
use App\Models\Certificate_Type;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditCertificates extends Component
{
    public $certName, $certTypeID, $certFrom, $certEarned, $certRate, $certID;

    public $userID;
    public $search;

    public $deleteCert;

    public function deleteData($id)
    {
        $this->reset('deleteCert');
        $this->deleteCert = $id;
        $this->dispatch('open-modal', 'delete-cert-modal');
    }

    public function deleteRecord()
    {
        // Fetch the education record to delete
        $cert = Certificate::findOrFail($this->deleteCert);

        // Check if the user has only one education record

        DB::beginTransaction();

        try {
            // Perform the deletion
            $cert->delete();

            // Commit the transaction if everything is successful
            DB::commit();

            // Optionally, close any modals or provide a success message
            $this->dispatch('close-modal', 'delete-cert-modal');
            toastr()->success('Certificate record has been successfully deleted!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            toastr()->error('There was an error while deleting the certificate record. Please try again later.');
        }

        // Optionally, reset variables or state after the operation
        $this->reset('deleteCert');
        $this->dispatch('close-modal', 'delete-cert-modal');
    }
    public function save()
    {
        $rules = [
            'certFrom' => [
                'required',
                'string',
                'max:255', // Optional: add a max length if needed
            ],
            'certEarned' => [
                'required',
                'date', // Ensures the value is a valid date
                'before_or_equal:today', // Optional: ensure the date is not in the future
            ],
            'certRate' => [
                'required',
                'numeric', // Ensures the value is a number
                'min:0', // Optional: ensures the value is non-negative
                'max:100', // Optional: if the rate should be a percentage, this limits it to 100
            ],
            'certTypeID' => [
                'required',
                Rule::unique('certificate', 'cert_Type_id') // Specify the correct column name
                    ->where(function ($query) {
                        // Ensure uniqueness for this employee and exclude trashed records
                        $query->where('employee_id', $this->userID)
                            ->whereNull('deleted_at'); // Exclude trashed records
                    })
                    ->ignore($this->certID, 'cert_id'), // Ignore the current record when updating
            ],
        ];

        $messages = [
            'certFrom.required' => 'The certificate provider is required.',
            'certFrom.string' => 'The certificate provider must be a string.',
            'certFrom.max' => 'The certificate provider must not exceed 255 characters.',
            'certEarned.required' => 'The date when the certificate was earned is required.',
            'certEarned.date' => 'The date earned must be a valid date.',
            'certEarned.before_or_equal' => 'The date earned must be today or in the past.',
            'certRate.required' => 'The certificate rate is required.',
            'certRate.numeric' => 'The certificate rate must be a number.',
            'certRate.min' => 'The certificate rate must be at least 0.',
            'certRate.max' => 'The certificate rate must not exceed 100.',
            'certTypeID.required' => 'The certificate type is required',
            'certTypeID.unique' => 'The certificate type has already been taken for this user.',

        ];

        // Validate input
        $this->validate($rules, $messages);

        // Begin transaction
        DB::beginTransaction();

        try {
            if ($this->certID) {
                // Update existing record
                $certificate = Certificate::find($this->certID);

                if (!$certificate) {
                    toastr()->error('Certificate not found.');
                    DB::rollBack();
                    return;
                }

                // Update attributes if they are changed
                $certificate->cert_Type_id = $this->certTypeID;
                $certificate->cert_From = $this->certFrom;
                $certificate->cert_Date_Issued = $this->certEarned;
                $certificate->cert_Rating = $this->certRate;

                if ($certificate->isDirty()) {
                    $certificate->save();
                    toastr()->success('Certificate Record has been Updated!');
                } else {
                    toastr()->info('No changes detected. Certificate Record remains the same.');
                }
            } else {
                // Create new record
                Certificate::create([
                    'employee_id' => $this->userID,
                    'cert_Type_id' => $this->certTypeID,
                    'cert_From' => $this->certFrom,
                    'cert_Date_Issued' => $this->certEarned,
                    'cert_Rating' => $this->certRate,
                ]);

                toastr()->success('New Certificate Record Created!');
            }

            DB::commit(); // Commit transaction
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on error
            toastr()->error('There was an Error: ' . $e->getMessage());
        }
        // Close the modal and dispatch an event
        $this->close();
        $this->dispatch('reload-table');
    }

    public function certtypeid($certid)
    {

        $this->certTypeID = $certid;
        $this->certName = Certificate_Type::find($certid)->cert_Name;
//iba sa Khen code idk if may bearing but its working lol
    }

    public function editModal($id)
    {
        $this->certID = $id;

        $certinfo = Certificate::find($id);

        $this->certName = $certinfo->certificateType->cert_Name;
        $this->certFrom = $certinfo->cert_From;
        $this->certEarned = Carbon::parse($certinfo->cert_Date_Issued)->format('Y-m-d');
        $this->certRate = $certinfo->cert_Rating;

        $this->certTypeID = $certinfo->cert_Type_id;

        $this->dispatch('open-modal', 'certificate-modal');
    }

    public function addModal()
    {
        $this->reset('certName', 'certFrom', 'certEarned', 'certRate', 'certID', 'search', 'certTypeID');
        $this->dispatch('open-modal', 'certificate-modal');
    }

    public function close()
    {
        $this->reset('certName', 'certFrom', 'certEarned', 'certRate', 'certID', 'search', 'certTypeID');
        $this->dispatch('close-modal', 'certificate-modal');
    }

    public function render()
    {
        $certs = Certificate::where('employee_id', '=', $this->userID)
            ->orderBy('cert_Date_Issued', 'desc')
            ->get();

        $certTypes = Certificate_Type::where('cert_Status', 1)->where('cert_Name', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.public.profile.jobseeker.partials.edit-certificates', compact('certs', 'certTypes'));
    }
}
