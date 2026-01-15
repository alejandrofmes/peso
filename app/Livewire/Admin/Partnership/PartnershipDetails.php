<?php

namespace App\Livewire\Admin\Partnership;

use App\Mail\PartnershipNotification;
use App\Models\Barangay;
use App\Models\Company;
use App\Models\Partnerships;
use App\Models\Requirements;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class PartnershipDetails extends Component
{

    public $id;

    public $businessName, $tradeName, $tin, $locType, $workforce, $empType, $empDesc, $companyAddress;
    public $bar, $mun, $prov;

    public $remarks;

    public function mount()
    {
        $user = Auth::user();

        // dd('hello');
        $partnersData = Partnerships::findOrFail($this->id);

        if ($partnersData) {

            if ($user->peso_accounts->peso_id != $partnersData->peso_id) {
                return $this->redirectRoute('dashboard');

            }
        } else {
            return $this->redirectRoute('dashboard');

        }

    }

    public function viewFile($reqPassedId)
    {

        $url = route('view.requirement');
        // Dispatch an event to trigger JavaScript for opening a new tab
        $this->dispatch('viewFile', [
            'url' => $url,
            'req_passed_id' => $reqPassedId,

        ]);

    }

    public function updatePartnership($id, $status, $modal)
    {

        // Validate the input
        $this->validate([
            'remarks' => 'required|string',
        ]);

        // Begin a transaction
        DB::beginTransaction();

        try {
            // Find and update the job posting
            $partnership = Partnerships::findOrFail($id);

            $partnership->update([
                'partnership_Status' => $status,
                'partnership_Remarks' => $this->remarks,
                'responded_at' => now(),
            ]);

            // If the status is ACTIVE, get the matching employees
            $user = $partnership->company->user;
            if ($user->usertype == 5) {
                $user->update(['usertype' => 6]);
            }

            Mail::to($partnership->company->user->email)->queue(new PartnershipNotification($partnership));

            // Commit the transaction
            DB::commit();

        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Log the error for debugging

            // Show an error message
            toastr()->error('An error occurred while updating the job posting.');
            return;
        }
        // Dispatch the event to close the modal
        $this->dispatch('close-modal', $modal);

        // Show a success message depending on the status
        if ($status === 'ACTIVE') {
            toastr()->success('Partnership Approved');
        } elseif ($status === 'REJECTED') {
            toastr()->success('Partnership Rejected');
        }
    }

    public function close($modal)
    {
        $this->dispatch('close-modal', $modal);
        $this->reset('remarks');

    }
    public function mountData($id)
    {

        $employerDetails = Company::with(['company_industry_line'])
            ->findOrFail($id);

        // COMPANY DETAILS
        $this->businessName = $employerDetails->business_Name;
        $this->tradeName = $employerDetails->trade_Name;
        $this->tin = $employerDetails->company_TIN;
        $this->locType = $employerDetails->company_Type;
        $this->workforce = $employerDetails->company_Total_workforce;
        $this->empType = $employerDetails->employer_Type;
        $this->empDesc = $employerDetails->employer_Type_Desc;
        $this->companyAddress = $employerDetails->company_Address;

        $barangay = Barangay::findOrFail($employerDetails->barangay_id);

        if ($barangay) {

            $this->bar = $barangay->barangay_Name;
            $this->mun = $barangay->municipality->municipality_Name;
            $this->prov = $barangay->municipality->province->province_Name;
        }

    }

    public function render()
    {
        $user = Auth::user();

        // dd('hello');
        $partnersData = Partnerships::findOrFail($this->id);

        if ($user->peso_accounts->peso_id != $partnersData->peso_id) {
            return redirect()->back();
        }

        $this->mountData($partnersData->company_id);

        $requirements = Requirements::with([
            'requirementPassed' => function ($query) use ($partnersData) {
                $query->where('company_id', $partnersData->company_id); // Use `where` for filtering
            },
        ])
            ->where('requirement_Status', 1)
            ->where('requirement_Type', $this->empType)
            ->get();

        return view('livewire.admin.partnership.partnership-details', compact('partnersData', 'requirements'));
    }
}
