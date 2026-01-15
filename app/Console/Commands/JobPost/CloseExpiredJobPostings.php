<?php

namespace App\Console\Commands\JobPost;

use App\Mail\JobpostClosedNotification;
use App\Models\Job_Posting;
use App\Services\CustomAuditLogger;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class CloseExpiredJobPostings extends Command implements ShouldQueue
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:close-expired-job-postings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close expired job postings and log the changes.';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the current date
        $now = Carbon::now();

        // Fetch job postings that are ACTIVE and expired
        $expiredJobPostings = Job_Posting::where('job_Status', 'ACTIVE')
            ->where('job_Duration', '<', $now)
            ->get();

        // Store old values for auditing
        $oldValues = $expiredJobPostings->mapWithKeys(function ($posting) {
            return [$posting->job_id => ['job_Status' => $posting->job_Status]];
        })->toArray();

        // Update job postings to CLOSED
        $affectedRows = Job_Posting::where('job_Status', 'ACTIVE')
            ->where('job_Duration', '<', $now)
            ->update(['job_Status' => 'CLOSED']);

        // Log the audit
        foreach ($expiredJobPostings as $posting) {
            CustomAuditLogger::log(
                Job_Posting::class,
                $posting->job_id,
                'updated',
                $oldValues[$posting->job_id] ?? [], // Old values
                ['job_Status' => 'CLOSED'], // New values
                0// System or user ID
            );

            Mail::to($posting->company->user->email)->queue(new JobpostClosedNotification($posting));
        }

        // Output the result in the console
        $this->info("Closed {$affectedRows} expired job postings.");
    }
}
