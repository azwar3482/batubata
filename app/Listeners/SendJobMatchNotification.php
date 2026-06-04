<?php

namespace App\Listeners;

use App\Events\JobVacancyCreated;
use App\Services\JobMatchingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendJobMatchNotification implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(JobVacancyCreated $event): void
    {
        $jobListing = $event->jobListing;
        $matchingService = new JobMatchingService();

        // Get all job seekers
        $seekers = \App\Models\User::where('role', 'job_seeker')->get();

        foreach ($seekers as $seeker) {
            try {
                $matchScore = $matchingService->calculateMatch($seeker, $jobListing);

                if ($matchScore >= 70) {
                    $seeker->notify(new \App\Notifications\NewJobMatchNotification($jobListing, $matchScore));
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("SendJobMatchNotification: Gagal menghitung match untuk user ID {$seeker->id}: " . $e->getMessage());
            }
        }
    }
}
