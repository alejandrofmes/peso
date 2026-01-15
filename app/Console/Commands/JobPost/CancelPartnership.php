<?php

namespace App\Console\Commands\JobPost;

use App\Mail\JobPostingCancellationNotification;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use App\Services\CustomAuditLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CancelPartnership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'partnership:cancel {companyId} {pesoId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel all job postings of a company and notify job applicants about the cancellation';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $companyId = $this->argument('companyId');
        $pesoId = $this->argument('pesoId');

        // Retrieve job postings by company and peso_id
        $jobPostings = Job_Posting::where('company_id', $companyId)
            ->where('peso_id', $pesoId)
            ->whereIn('job_Status', ['PENDING', 'ACTIVE', 'CLOSED'])
            ->get();

        foreach ($jobPostings as $jobPosting) {
            // Store old values for auditing
            $oldJobPostingValues = [
                'job_Status' => $jobPosting->job_Status,
            ];

            // Update the job posting status to CANCELLED
            $jobPosting->job_Status = 'CANCELLED';
            $jobPosting->save();

            // Log the audit for job posting updates
            // CustomAuditLogger::log(
            //     Job_Posting::class,
            //     $jobPosting->job_id,
            //     'updated',
            //     $oldJobPostingValues, // Old values
            //     ['job_Status' => 'CANCELLED'], // New values
            //     0// System or user ID
            // );

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
                    // $oldApplicantValues['peso_Status'] = 'CANCELLED';
                    // $oldApplicantValues['peso_Remarks'] = 'Job posting was cancelled';
                    $newValues['peso_Status'] = 'CANCELLED';
                    $newValues['peso_Remarks'] = 'Job posting was cancelled';
                }

                // CustomAuditLogger::log(
                //     Job_Applicants::class,
                //     $applicant->applicant_id,
                //     'updated',
                //     $oldApplicantValues, // Old values
                //     $newValues, // New values
                //     0// System or user ID
                // );

                // Notify the applicant via email
                Mail::to($applicant->employee->user->email)->queue(new JobPostingCancellationNotification($applicant));
            }
        }

        $this->info('All job postings have been cancelled, applicants updated, and notifications sent.');
    }
}
