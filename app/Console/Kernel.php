<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\JobPost\CloseExpiredJobPostings::class,
        \App\Console\Commands\JobPost\CompleteJobPostings::class,
        \App\Console\Commands\JobPost\NotifyCompletionDeadline::class,
        \App\Console\Commands\JobPost\ProcessClosedJobPosting::class,
        \App\Console\Commands\Training\CloseExpiredTrainings::class,

    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:close-expired-job-postings')->dailyAt('00:00');
        $schedule->command('app:complete-job-postings')->dailyAt('00:00');
        $schedule->command('app:notify-completion-deadline')->dailyAt('00:00');
        $schedule->command('app:close-expired-trainings')->dailyAt('00:00');
        $schedule->command('backup:run --only-db --only-to-disk=google')->dailyAt('00:00');
        $schedule->command('backup:run --only-files --only-to-disk=googleFiles')->dailyAt('00:00');

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
