<?php

namespace App\Console\Commands\JobPost;

use App\Mail\JobApplicationExpiredNotification;
use App\Mail\JobpostCompletedNotification;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use App\Services\CustomAuditLogger;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CompleteJobPostings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:complete-job-postings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark closed job postings as completed and reject applicable job applicants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current date
        $now = Carbon::now();

        // Fetch job postings that have been closed for more than 2 weeks
        $expiredJobPostings = Job_Posting::where('job_Status', 'CLOSED')
            ->where('job_Duration', '<', $now->subWeeks(2)) // Ensure you use `job_Duration`
            ->get();

        // Store old values for auditing
        $oldJobPostingValues = $expiredJobPostings->mapWithKeys(function ($posting) {
            return [$posting->job_id => ['job_Status' => $posting->job_Status]];
        })->toArray();

        // Update job postings to COMPLETED
        $affectedRows = Job_Posting::where('job_Status', 'CLOSED')
            ->where('job_Duration', '<', $now) // Ensure you use `job_Duration`
            ->update(['job_Status' => 'COMPLETED']);

        // Log the audit for job postings
        foreach ($expiredJobPostings as $posting) {
            CustomAuditLogger::log(
                Job_Posting::class,
                $posting->job_id,
                'updated',
                $oldJobPostingValues[$posting->job_id] ?? [], // Old values
                ['job_Status' => 'COMPLETED'], // New values
                0// System or user ID
            );
            Mail::to($posting->company->user->email)->queue(new JobpostCompletedNotification($posting));
        }

        // Fetch job postings that are now COMPLETED
        $completedJobPostings = Job_Posting::where('job_Status', 'COMPLETED')
            ->pluck('job_id');

        // Fetch and store old values for job applicants
        $affectedApplicants = Job_Applicants::whereIn('job_id', $completedJobPostings)
            ->whereNotIn('applicant_Status', ['REJECTED', 'ACCEPTED', 'CANCELLED'])
            ->get();

        foreach ($affectedApplicants as $applicant) {
            // Default update data
            $updateData = [
                'applicant_Status' => 'REJECTED',
                'company_Remarks' => 'Job Posting Completed',
            ];

            // Prepare old values for audit logging
            $oldValues = [
                'applicant_Status' => $applicant->applicant_Status,
                'company_Remarks' => $applicant->company_Remarks,
            ];

            // Check if peso_Status needs to be updated
            if ($applicant->peso_Status === 'PENDING') {
                $updateData['peso_Status'] = 'CANCELLED';
                $updateData['peso_Remarks'] = 'Job Posting Was Completed';
                $oldValues['peso_Status'] = $applicant->peso_Status;
                $oldValues['peso_Remarks'] = $applicant->peso_Remarks;
            }

            // Update the applicant record
            $applicant->update($updateData);

            // Prepare new values for audit logging, including peso_Status if updated
            $newValues = [
                'applicant_Status' => 'REJECTED',
                'company_Remarks' => 'Job Posting Completed',
            ];

            // Include peso_Status and peso_Remarks in newValues only if they are updated
            if (isset($updateData['peso_Status'])) {
                $newValues['peso_Status'] = $updateData['peso_Status'];
            }
            if (isset($updateData['peso_Remarks'])) {
                $newValues['peso_Remarks'] = $updateData['peso_Remarks'];
            }

            // Log the audit for applicant updates
            CustomAuditLogger::log(
                Job_Applicants::class,
                $applicant->applicant_id,
                'updated',
                $oldValues, // Old values
                $newValues, // New values
                0// System or user ID
            );

            // Queue email to remaining applicants
            Mail::to($applicant->employee->user->email)->queue(new JobApplicationExpiredNotification($applicant));
        }

        // Output the result in the console
        $this->info("Completed {$affectedRows} job postings and updated {$affectedApplicants->count()} job applicants.");
    }

}
