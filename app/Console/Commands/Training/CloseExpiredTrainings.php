<?php

namespace App\Console\Commands\Training;

use App\Models\Programs;
use App\Services\CustomAuditLogger;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CloseExpiredTrainings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:close-expired-trainings';

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
        $now = Carbon::now();

        // Fetch programs that are ACTIVE and expired
        $expiredPrograms = Programs::where('program_Status', 'ACTIVE')
            ->where('program_Deadline', '<', $now)
            ->get();

        // Store old values for auditing
        $oldValues = $expiredPrograms->mapWithKeys(function ($program) {
            return [$program->program_id => ['program_Status' => $program->program_Status]];
        })->toArray();

        // Update programs to CLOSED
        $affectedRows = Programs::where('program_Status', 'ACTIVE')
            ->where('program_Deadline', '<', $now)
            ->update(['program_Status' => 'CLOSED']);

        // Log the audit
        foreach ($expiredPrograms as $program) {
            CustomAuditLogger::log(
                Programs::class,
                $program->program_id,
                'updated',
                $oldValues[$program->program_id] ?? [], // Old values
                ['program_Status' => 'CLOSED'], // New values
                0// System or user ID
            );

        }

        // Output the result in the console
    }
}
