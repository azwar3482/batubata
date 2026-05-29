<?php

namespace App\Listeners;

use App\Events\JobVacancyCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendJobMatchNotification
{
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

        // Get all job seekers
        $seekers = \App\Models\User::where('role', 'job_seeker')->get();

        foreach ($seekers as $seeker) {
            $match = false;

            // Simple match by title/position
            if ($seeker->target_position && stripos($jobListing->title, $seeker->target_position) !== false) {
                $match = true;
            }

            // Simple match by skills intersection
            if (!$match && $seeker->skills && $jobListing->required_skills) {
                $seekerSkills = is_array($seeker->skills) ? $seeker->skills : json_decode($seeker->skills, true) ?? [];
                $jobSkills = is_array($jobListing->required_skills) ? $jobListing->required_skills : json_decode($jobListing->required_skills, true) ?? [];

                $intersection = array_intersect(
                    array_map('strtolower', $seekerSkills),
                    array_map('strtolower', $jobSkills)
                );

                if (count($intersection) > 0) {
                    $match = true;
                }
            }

            if ($match) {
                $seeker->notify(new \App\Notifications\JobVacancyMatched($jobListing));
            }
        }
    }
}
