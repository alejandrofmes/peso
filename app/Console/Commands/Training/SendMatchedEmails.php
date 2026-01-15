<?php
namespace App\Console\Commands\Training;

use App\Mail\TrainingPostingNotification;
use App\Models\Employee;
use App\Models\Programs;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMatchedEmails extends Command implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-matched-emails {programId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notifications to employees matched with the given program ID';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Retrieve the programId argument
        $programId = $this->argument('programId');

        // Find the training program using the passed ID
        $trainingProgram = Programs::find($programId);

        if (!$trainingProgram) {
            $this->error("Program not found.");
            return;
        }

        $matchingJobseekers = $this->getMatched($trainingProgram);

        if ($matchingJobseekers->isNotEmpty()) {
            foreach ($matchingJobseekers as $employee) {
                Mail::to($employee->user->email)->queue(new TrainingPostingNotification($employee, $trainingProgram));
            }
        } else {
            $this->info("No matching jobseekers found.");
        }
    }

    /**
     * Get matched jobseekers for the given program.
     *
     * @param Programs $programInfo
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getMatched($programInfo)
    {
        $programMunicipalityId = $programInfo->peso->municipality_id;
        $jobIndustryId = $programInfo->industry_id;
        $jobTagIds = $programInfo->program_tags->pluck('position_id');

        return Employee::whereHas('barangay.municipality', function ($query) use ($programMunicipalityId) {
            $query->where('municipality_id', $programMunicipalityId);
        })
            ->whereHas('job_preference', function ($query) use ($jobTagIds) {
                $query->whereIn('position_id', $jobTagIds);
            })
            ->withCount(['job_preference as num_matched_tags' => function ($query) use ($jobTagIds) {
                $query->whereIn('position_id', $jobTagIds);
            }])
            ->withCount(['industry_preference as num_matched_industry' => function ($query) use ($jobIndustryId) {
                $query->where('industry_id', $jobIndustryId);
            }])
            ->orderByRaw('
                CASE
                    WHEN num_matched_industry > 0 AND num_matched_tags > 0 THEN 1
                    WHEN num_matched_industry > 0 AND num_matched_tags = 0 THEN 2
                    WHEN num_matched_industry = 0 AND num_matched_tags > 0 THEN 3
                    ELSE 4
                END
            ')
            ->orderByDesc('num_matched_tags')
            ->get();
    }
}
