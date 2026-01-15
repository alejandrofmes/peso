<?php

namespace App\Console\Commands\Users;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteUnverifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-unverified-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users with usertype 2 or 3 who are unverified after 3 days';

    // Constructor
    public function __construct()
    {
        parent::__construct();
    }

    // Execute the console command
    public function handle()
    {
        // Calculate the cutoff date (3 days ago)
        $cutoffDate = Carbon::now()->subDays(3);

        // Find users with usertype 2 or 3 who are unverified after 3 days
        $users = User::whereIn('usertype', [2, 3])
            ->whereNull('email_verified_at') // Assuming 'email_verified_at' is used for verification
            ->where('created_at', '<', $cutoffDate)
            ->get();

        // Delete each user and ensure it is recorded by Laravel Auditing
        foreach ($users as $user) {
            $user->delete(); // This will trigger the audit logs
        }

        // Output the result
        $this->info("Deleted {$users->count()} unverified users with usertype 2 or 3 who were registered before {$cutoffDate->toDateTimeString()}.");

        return 0;
    }
}
