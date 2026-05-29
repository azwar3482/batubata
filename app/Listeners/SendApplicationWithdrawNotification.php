<?php

namespace App\Listeners;

use App\Events\JobApplicationWithdrawn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendApplicationWithdrawNotification
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
    public function handle(JobApplicationWithdrawn $event): void
    {
        $application = $event->application;
        $jobListing = $application->jobListing;

        // Ensure the company has a user to notify. We notify the company user.
        if ($jobListing && $jobListing->user_id) {
            $companyUser = \App\Models\User::find($jobListing->user_id);
            if ($companyUser) {
                $companyUser->notify(new \App\Notifications\JobApplicationWithdrawn($application));
            }
        }
    }
}
