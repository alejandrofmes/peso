<?php

namespace App\Livewire\Components;

use App\Models\Job_Applicants;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ApplicationsNotifMobile extends Component
{
    public function render()
    {

        $user = Auth::user();

        $ApplicationNotif = Job_Applicants::where('employee_id', $user->employee->employee_id)
            ->where('applicant_Notif', 1)->count();

        return view('livewire.components.applications-notif-mobile', compact('ApplicationNotif'));
    }
}
