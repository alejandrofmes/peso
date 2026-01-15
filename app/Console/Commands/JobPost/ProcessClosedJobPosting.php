<?php


namespace App\Console\Commands\JobPost;

use App\Mail\ApplicationFull;
use App\Mail\SlotsFilled;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use App\Services\CustomAuditLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProcessClosedJobPosting extends Command
{
    protected $signature = 'jobposting:process {jobId}';
    protected $description = 'Close job posting if no slots left and notify remaining applicants.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $jobId = $this->argument('jobId');

        DB::beginTransaction();
        try {
            // Find the job posting
            $jobPosting = Job_Posting::find($jobId);

            if ($jobPosting && $jobPosting->slotsLeft() <= 0) {
                // Store old values for auditing
                $oldJobPostingValues = [
                    'job_Status' => $jobPosting->job_Status,
                ];

                // Mark the job posting as closed
                $jobPosting->update([
                    'job_Status' => 'COMPLETED', // Assuming 'CLOSED' is the status for closed job postings
                ]);

                // Log the job posting update
                CustomAuditLogger::log(
                    Job_Posting::class,
                    $jobId,
                    'updated',
                    $oldJobPostingValues, // Old values
                    ['job_Status' => 'COMPLETED'], // New values
                    0// System or user ID
                );

                Mail::to($jobPosting->company->user->email)
                    ->queue(new SlotsFilled($jobPosting));

                // Find remaining applicants who are not ACCEPTED, REJECTED, or CANCELLED
                $remainingApplicants = Job_Applicants::where('job_id', $jobId)
                    ->whereNotIn('applicant_Status', ['ACCEPTED', 'REJECTED', 'CANCELLED'])
                    ->get();

                foreach ($remainingApplicants as $remainingApplicant) {
                    // Store old values for auditing
                    $oldApplicantValues = [
                        'applicant_Status' => $remainingApplicant->applicant_Status,
                        'peso_Status' => $remainingApplicant->peso_Status,
                        'peso_Remarks' => $remainingApplicant->peso_Remarks,
                        'company_Remarks' => $remainingApplicant->company_Remarks,
                        'applicant_Notif' => $remainingApplicant->applicant_Notif,
                    ];

                    $updateData = [
                        'applicant_Status' => 'CANCELLED',
                        'company_Remarks' => 'Position has already been filled',
                        'applicant_Notif' => 2,
                    ];

                    // Check if peso_Status needs to be updated
                    if ($remainingApplicant->peso_Status === 'PENDING') {
                        $updateData['peso_Status'] = 'CANCELLED';
                        $updateData['peso_Remarks'] = 'Job Posting was completed.';
                    }

                    // Update the applicant record
                    $remainingApplicant->update($updateData);

                    // Log the applicant update
                    CustomAuditLogger::log(
                        Job_Applicants::class,
                        $remainingApplicant->applicant_id,
                        'updated',
                        $oldApplicantValues, // Old values
                        $updateData, // New values
                        0// System or user ID
                    );

                    // Queue email to remaining applicants
                    Mail::to($remainingApplicant->employee->user->email)
                        ->queue(new ApplicationFull($remainingApplicant->employee, $remainingApplicant));
                }
            }

            DB::commit();
            $this->info('Job posting closed and applicants notified.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error closing job posting: ' . $e->getMessage());
        }
    }
}
