<?php

namespace App\Livewire\Admin\Certificates;

use App\Models\Certificate_Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Certificates extends Component
{

    use WithPagination;
    use WithoutUrlPagination;

    public $search;
    public $rows = 10;

    public $certCode, $certName;

    public $editcertID, $editcertCode, $editcertName;

    public $archiveCert;
    public $restoreCert;

    public $filterCert = 'All';
    public function updatedSearch()
    {
        $this->resetPage(); // This will reset the pagination to page 1
    }
    public function updateFilter($value)
    {

        $this->filterCert = $value;

    }
    public function archiveConfirmation($id)
    {
        $this->reset('archiveCert');
        $this->archiveCert = $id;
        $this->dispatch('open-modal', 'delete-cert-modal');

    }

    public function confirmArchive()
    {
        DB::beginTransaction();

        try {
            $certificate = Certificate_Type::findOrFail($this->archiveCert);
            $certificate->cert_Status = 2;
            $certificate->save();

            DB::commit();

            $this->dispatch('close-modal', 'delete-cert-modal');
            toastr()->success('Certifcate Type was successfully archived!');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('There was an error. Please try again later.');
            // Log the exception if necessary
            Log::error('Error archiving: ' . $e->getMessage());
        }
        $this->reset('archiveCert');

    }
    public function restoreConfirmation($id)
    {
        $this->reset('restoreCert');
        $this->restoreCert = $id;
        $this->dispatch('open-modal', 'restore-cert-modal');

    }

    public function confirmRestore()
    {
        DB::beginTransaction();

        try {
            $certificate = Certificate_Type::findOrFail($this->restoreCert);
            $certificate->cert_Status = 1;
            $certificate->save();

            DB::commit();

            $this->dispatch('close-modal', 'restore-cert-modal');
            toastr()->success('Certifcate Type was successfully restored!');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('There was an error. Please try again later.');
            // Log the exception if necessary
            Log::error('Error archiving: ' . $e->getMessage());
        }
        $this->reset('restoreCert');

    }
    public function saveCertificate()
    {
        $rules = ['certCode' => ['required', 'string', Rule::unique('certificate_type', 'cert_Code')],
            'certName' => ['required', 'string', Rule::unique('certificate_type', 'cert_Name')]];

        $messages = [
            'certCode.required' => 'The certificate code is required.',
            'certCode.string' => 'The certificate code must be a string.',
            'certCode.unique' => 'The certificate code has already been taken.',
            'certName.required' => 'The certificate name is required.',
            'certName.string' => 'The certificate name must be a string.',
            'certName.unique' => 'The certificate name has already been taken.',
        ];

        $this->validate($rules, $messages);

        DB::beginTransaction();
        try {
            Certificate_Type::create([
                'cert_Code' => strtoupper($this->certCode),
                'cert_Name' => $this->certName,
            ]);

            // $this->reset();
            DB::commit();
            toastr()->success('New Certificate Created!');

            $this->reset('certCode', 'certName');
            $this->resetValidation();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->reset('cert_Code', 'cert_Name');
            $this->resetValidation();
            toastr()->error('There was an error.');
        }
    }

    public function editCertificate($id)
    {
        $certType = Certificate_Type::find($id);

        if ($certType) {
            $this->editcertID = $certType->cert_type_id;
            $this->editcertCode = $certType->cert_Code;
            $this->editcertName = $certType->cert_Name;
            $this->dispatch('open-modal', 'certificate-modal');
        } else {
            toastr()->error('There was an error fetching the data.');
        }
    }

    public function updateCertificate()
    {
        $rules = [
            'editcertCode' => ['required', 'string', Rule::unique('certificate_type', 'cert_Code')->ignore($this->editcertID, 'cert_type_id')],
            'editcertName' => ['required', 'string', Rule::unique('certificate_type', 'cert_Name')->ignore($this->editcertID, 'cert_type_id')],
        ];

        $messages = [
            'editcertCode.required' => 'The certificate code is required.',
            'editcertCode.string' => 'The certificate code must be a string.',
            'editcertCode.unique' => 'The certificate code has already been taken.',
            'editcertName.required' => 'The certificate name is required.',
            'editcertName.string' => 'The certificate name must be a string.',
            'editcertName.unique' => 'The certificate name has already been taken.',
        ];

        $this->validate($rules, $messages);

        DB::beginTransaction();

        try {
            // Use Eloquent to find the record
            $certificate = Certificate_Type::find($this->editcertID);

            if (!$certificate) {
                toastr()->error('Certificate not found!');
                DB::rollBack();
                return;
            }

            // Update the certificate attributes
            $certificate->cert_Code = strtoupper($this->editcertCode);
            $certificate->cert_Name = $this->editcertName;

            // Check if any attributes are dirty
            if ($certificate->isDirty()) {
                $certificate->save(); // Save only if there are changes

                // Commit the transaction
                DB::commit();
                toastr()->success('Certificate Updated!');
            } else {
                // No changes to save
                DB::rollBack();
                toastr()->info('No changes detected.');
            }
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();
            toastr()->error('There was an Error');
        }

        $this->close();
    }

    public function close()
    {
        $this->dispatch('close-modal', 'certificate-modal');
        $this->resetValidation();
        $this->reset('editcertID', 'editcertCode', 'editcertName');
    }

    public function render()
    {

        $query = Certificate_Type::where('cert_Name', 'like', '%' . $this->search . '%');

        // Apply filtering logic based on the selected filterCert value
        if ($this->filterCert == 'All') {

            $query->where('cert_Status', 1);
        } elseif ($this->filterCert == 'Archived') {

            $query->where('cert_Status', 2);
        }

        $certificate_type = $query->orderBy('cert_Name', 'asc')->paginate($this->rows);

        return view('livewire.admin.certificates.certificates', compact('certificate_type'));
    }
}
