<?php

namespace App\Console\Commands\JobPost;

use App\Mail\JobPostingCancellationNotification;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use App\Services\CustomAuditLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CancelJobPosting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-job-posting {jobId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Retrieve jobId as an argument
        $jobId = $this->argument('jobId');

        // Retrieve the job posting by job_id
        $jobPosting = Job_Posting::findOrFail($jobId);

        if (!$jobPosting) {
            $this->error("Job posting not found or is already cancelled.");
            return;
        }

        // Notify all job applicants about the cancellation and update their status
        $jobApplicants = $jobPosting->job_applicants;

        foreach ($jobApplicants as $applicant) {
            // Store old values for auditing
            $oldApplicantValues = [
                'applicant_Status' => $applicant->applicant_Status,
                'company_Remarks' => $applicant->company_Remarks,
            ];

            // Update applicant status to CANCELLED
            $applicant->applicant_Status = 'CANCELLED';
            $applicant->company_Remarks = 'Job posting was cancelled';

            // Update related peso_status and remarks if pending
            if ($applicant->peso_Status === 'PENDING') {
                $applicant->peso_Status = 'CANCELLED';
                $applicant->peso_Remarks = 'Job posting was cancelled';
            }

            $applicant->save();

            // Log the audit for applicant updates
            $newValues = [
                'applicant_Status' => 'CANCELLED',
                'company_Remarks' => 'Job posting was cancelled',
            ];

            // Include peso_Status and peso_Remarks in newValues only if they are updated
            if ($applicant->peso_Status === 'CANCELLED') {
                $newValues['peso_Status'] = 'CANCELLED';
                $newValues['peso_Remarks'] = 'Job posting was cancelled';
            }

            CustomAuditLogger::log(
                Job_Applicants::class,
                $applicant->applicant_id,
                'updated',
                $oldApplicantValues, // Old values
                $newValues, // New values
                0// System or user ID
            );

            // Notify the applicant via email
            Mail::to($applicant->employee->user->email)->queue(new JobPostingCancellationNotification($applicant));

        }

        $this->info("Job posting (ID: $jobId) has been cancelled, applicants updated, and notifications sent.");
    }

}
