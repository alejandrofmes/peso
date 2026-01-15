<?php

namespace App\Livewire\Admin\Training;

use App\Mail\ConfirmTraining;
use App\Mail\DeclineTraining;
use App\Mail\ProgramCompleteNotification;
use App\Models\Barangay;
use App\Models\Industry_preference;
use App\Models\Job_Preference;
use App\Models\Programs;
use App\Models\Program_Reg;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelWriter;

#[Layout('layouts.admin')]
class TrainingRegistrants extends Component
{

    use WithPagination, WithoutUrlPagination;
    public $id;

    public $search;

    public $selectedJobseeker;

    public $sortDate, $filter = 'All';

    public $agreeBox = false;

    protected $listeners = ['qrCodeScanned' => 'qrCodeScanned'];

    public function updatedsearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $user = Auth::user();

        $programInfo = Programs::findOrFail($this->id);

        if ($programInfo) {
            if ($user->peso_accounts->peso_id != $programInfo->peso_id) {
                return $this->redirectRoute('dashboard');
            }
        } else {
            return $this->redirectRoute('dashboard');
        }
    }

    public function completeProgram()
    {
        $programInfo = Programs::find($this->id);
        if ($programInfo) {
            $programInfo->update(['program_Status' => 'COMPLETED']);

            $registeredUsers = $programInfo->program_reg->where('program_reg_Status', 'COMPLETED');
            if ($registeredUsers) {
                foreach ($registeredUsers as $jobseeker) {
                    // Notify each user via email (assuming you have a mailable for this)
                    Mail::to($jobseeker->employee->user->email)->queue(new ProgramCompleteNotification($jobseeker->employee, $programInfo));
                }

                // Success message
                toastr()->success('Program has been completed. Registered users will be notified via email.');

                $updateAll = Program_reg::where('program_id', $this->id)
                    ->where('program_reg_Status', 'REGISTERED')
                    ->get();

                // Proceed only if there are records to update
                if ($updateAll->isNotEmpty()) {
                    DB::transaction(function () use ($updateAll) {
                        // Update the status of registered users
                        Program_reg::where('program_id', $this->id)
                            ->where('program_reg_Status', 'REGISTERED')
                            ->update([
                                'program_reg_Status' => 'CANCELLED',
                                'responded_at' => now(),
                            ]);
                    });
                }
            }
        } else {
            toastr()->error('There was an error in the transaction. Please try again later.');
        }

        $this->dispatch('close-modal', 'complete-modal');
    }

    public function getJobseeker($id)
    {
        $this->selectedJobseeker = $id;
        // dd($id);
        $this->reset('sortDate');
    }

    public function changeFilter($filter)
    {
        $this->filter = $filter;
        $this->reset('sortDate');
        $this->resetPage();
    }
    public function updateSort($sort)
    {
        $this->sortDate = $sort;
        $this->resetPage();
    }

    public function scanQr()
    {
        $this->dispatch('open-modal', 'qr-scanner-modal');
        $this->dispatch('startScanner');
    }
    public function qrStop()
    {
        $this->dispatch('endScanner');
        $this->dispatch('close-modal', 'qr-scanner-modal');
    }

    public function qrCodeScanned($decodedText)
    {
        try {
            // Attempt to decrypt the QR code content
            $decryptedText = Crypt::decrypt($decodedText);

            // Decode the decrypted JSON data
            $ticketData = json_decode($decryptedText, true);

            // Fetch the ticket based on the provided data
            $ticket = Program_Reg::where('program_reg_id', $ticketData['program_reg_id'])
                ->where('program_id', $ticketData['program_id'])
                ->where('employee_id', $ticketData['employee_id'])
                ->where('created_at', Carbon::createFromFormat('Y-m-d H:i:s', $ticketData['created_at']))
                ->first();

            // Check if the ticket is found
            if ($ticket && $ticket->program_id == $this->id) {
                $this->getJobseeker($ticket->program_reg_id);
                $this->dispatch('close-modal', 'qr-scanner-modal');
            } else {
                toastr()->info('Ticket is not valid.');
                $this->qrStop();
            }
        } catch (DecryptException $e) {
            // Handle decryption error (e.g., payload tampered or invalid)
            Log::error('Decryption error in QR code scan: ' . $e->getMessage(), ['exception' => $e]);

            toastr()->error('An error occurred while processing the ticket.');
            $this->qrStop();
        } catch (\Exception $e) {
            // Handle any other exceptions
            Log::error('General error in QR code scan: ' . $e->getMessage(), ['exception' => $e]);
            toastr()->error('An error occurred while processing the ticket.');
            $this->qrStop();
        }
    }

    public function confirmReg($action, $id)
    {
        DB::beginTransaction();

        try {
            // Retrieve the model instance using Eloquent
            $programReg = Program_Reg::find($id);

            if (!$programReg) {
                toastr()->error('Job seeker not found.');
                DB::rollBack();
                return;
            }

            // Update the model attributes
            $programReg->program_reg_Status = $action;
            $programReg->responded_at = now();

            // Check if any attributes are dirty
            if ($programReg->isDirty()) {
                // Save changes only if there are modifications
                $programReg->save();
            }

            // Commit the transaction
            DB::commit();

            $programInfo = Programs::find($this->id);

            if ($programInfo->program_Status == 'ACTIVE') {
                $currentRegistrations = $programInfo->program_reg->whereIn('program_reg_Status', ['ATTENDEE', 'COMPLETED'])->count();

                // If the number of registrations has reached the slots, update the program status to "CLOSED"
                if ($currentRegistrations >= $programInfo->program_Slots) {
                    $willCancelUsers = Program_reg::where('program_reg_Status', 'REGISTERED')
                        ->where('program_id', $this->id)
                        ->get();

                    // Proceed only if there are registered users
                    if ($willCancelUsers->isNotEmpty()) {
                        // Begin a transaction to ensure atomicity
                        DB::transaction(function () use ($willCancelUsers) {
                            // Update the status of registered users
                            $willCancelUsers->each(function ($user) {
                                $user->update([
                                    'program_reg_Status' => 'CANCELLED',
                                    'responded_at' => now(),
                                ]);
                            });
                        });
                    }

                    $this->emailRegistrants();
                    toastr()->success('Program slots are full. Registered users will be notified via email.');
                }
            } else {
                toastr()->success('Job seeker successfully updated.');
            }
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            // Show error notification
            toastr()->error('There was a problem updating the job seeker. Please try again.');
        }
    }

    public function emailRegistrants()
    {
        $programInfo = Programs::find($this->id);

        $programInfo->update(['program_Status' => 'CLOSED']);

        $registeredUsers = $programInfo->program_reg->where('program_reg_Status', 'ATTENDEE');
        if ($registeredUsers->isNotEmpty()) {
            foreach ($registeredUsers as $jobseeker) {
                // Notify each user via email (assuming you have a mailable for this)
                Mail::to($jobseeker->employee->user->email)->queue(new ConfirmTraining($jobseeker->employee, $programInfo));
            }
        }
        try {
            $declinedRegistrants = Program_reg::where('program_reg_Status', 'CANCELLED')->get();

            if ($declinedRegistrants->isNotEmpty()) {
                foreach ($declinedRegistrants as $jobseeker) {
                    Mail::to($jobseeker->employee->user->email)->queue(new DeclineTraining($jobseeker->employee, $programInfo));
                }
            }
        } catch (\Exception $e) {
            toastr()->error('There was a problem updating the job seeker. Please try again.');
        }
    }

    public function exportData()
    {

        $registrants = $this->getRegistrants($this->id)->get();

        if (!$registrants->isEmpty()) {

            $fileName = $registrants->first()->program_id . '-program_registrants-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

            $writer = SimpleExcelWriter::streamDownload($fileName);

            foreach ($registrants as $data) {
                $writer->addRow([
                    'Last Name' => $data->employee->lname,
                    'First Name' => $data->employee->mname,
                    'Middle Name' => $data->employee->fname,
                    'Status' => $data->program_reg_Status,
                    'Date Registered' => $data->created_at->format('F j, Y'),
                    'Gender' => $data->employee->gender == 1 ? 'MALE' : ($data->employee->gender == 2 ? 'FEMALE' : 'UNKNOWN'),
                    'Birth Date' => $data->employee->birthdate->format('Y-m-d'),
                    'Address' => $data->employee->address . " " . $data->employee->barangay->barangay_Name,

                ]);
            }

            toastr()->success('Data Exported');
            return Response::streamDownload(function () use ($writer) {
                $writer->close();
            }, $fileName, ['Content-Type' => 'text/csv']);
        }

        return toastr()->warning('No data in the table to be exported.');
    }

    public function isMatch($programId, $jobseekerInfo)
    {
        if (!$jobseekerInfo->employee) {
            return false;
        }

        $employeeId = $jobseekerInfo->employee->employee_id;

        // Get municipality ID
        $employeeMunicipalityId = Barangay::where('barangay_id', $jobseekerInfo->employee->barangay_id)
            ->value('municipality_id');

        // Get preferences
        $employeeJobPreferences = Job_Preference::where('employee_id', $employeeId)
            ->pluck('position_id')
            ->toArray();

        $employeeIndustryPreference = Industry_preference::where('employee_id', $employeeId)
            ->pluck('industry_id')
            ->toArray();

        return Programs::where('program_id', $programId)
            ->whereHas('peso', function ($query) use ($employeeMunicipalityId) {
                $query->where('municipality_id', $employeeMunicipalityId);
            })
        // This will check if there's ANY match (either industry or position)
            ->where(function ($query) use ($employeeJobPreferences, $employeeIndustryPreference) {
                // Check for industry match
                if (!empty($employeeIndustryPreference)) {
                    $query->whereHas('job_industry', function ($q) use ($employeeIndustryPreference) {
                        $q->whereIn('industry_id', $employeeIndustryPreference);
                    });
                }

                // Check for position match
                if (!empty($employeeJobPreferences)) {
                    $query->orWhereHas('program_tags', function ($q) use ($employeeJobPreferences) {
                        $q->whereIn('position_id', $employeeJobPreferences);
                    });
                }
            })
            ->exists();
    }
    public function getRegistrants($id)
    {
        $query = Program_Reg::with(['employee', 'programs.program_tags', 'programs.job_industry'])
            ->where('program_id', $id)
            ->whereHas('employee', function ($query) {
                $query->where('fname', 'like', '%' . $this->search . '%')
                    ->orWhere('mname', 'like', '%' . $this->search . '%')
                    ->orWhere('lname', 'like', '%' . $this->search . '%');
            });

        if ($this->filter != 'All') {
            if ($this->filter == 'Others') {
                $query->whereNotIn('program_reg_Status', ['REGISTERED', 'COMPLETED']);
            } else {
                $query->where('program_reg_Status', $this->filter);
            }
        }

        if ($this->sortDate !== null && $this->sortDate !== '') {
            $query->orderBy('created_at', $this->sortDate);
        }

        return $query;
    }

    public function render()
    {

        $programInfo = Programs::withCount('program_reg')
            ->findOrFail($this->id);
        $jobseekerInfo = null;
        $isMatch = false;
        $slotsRemaining = 0;

        // Paginate the results
        $programRegistrants = $this->getRegistrants($programInfo->program_id)->paginate(10);

        if ($this->selectedJobseeker) {
            $jobseekerInfo = Program_Reg::findOrFail($this->selectedJobseeker);

            // Determine if the jobseeker matches the program criteria
            $isMatch = $this->isMatch($programInfo->program_id, $jobseekerInfo);
        }

        return view('livewire.admin.training.training-registrants', compact('programInfo', 'programRegistrants', 'jobseekerInfo', 'isMatch'));
    }
}
