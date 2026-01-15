<?php


namespace App\Console\Commands\JobPost;

use App\Mail\JobpostReminder;
use App\Models\Job_Posting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyCompletionDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-completion-deadline';

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
        // Get the current date
        // Get the current date
        $now = Carbon::now()->startOfDay(); // Current date at midnight

        // Calculate the date that is exactly 3 days before today
        $threeDaysAgo = $now->subDays(3); // 3 days ago from today

        // Fetch job postings with CLOSED status and deadline exactly 3 days ago (date only, time ignored)
        $jobPostings = Job_Posting::where('job_Status', 'CLOSED')
            ->whereDate('job_Duration', $threeDaysAgo->toDateString()) // Compare date only
            ->get();

        // Send an email to the employer for each job posting
        foreach ($jobPostings as $posting) {
            // Check if the company has an associated user and email
            if ($posting->company && $posting->company->user && $posting->company->user->email) {
                Mail::to($posting->company->user->email)
                    ->queue(new JobpostReminder($posting));
            }
        }

        // Output the result in the console
        $this->info("Sent completion reminder emails for job postings with deadline {$threeDaysAgo->toDateString()}.");

        return 0;
    }
}
