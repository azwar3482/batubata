<?php

namespace App\Listeners;

use App\Events\JobApplicationStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendApplicationStatusNotification
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
    public function handle(JobApplicationStatusChanged $event): void
    {
        $application = $event->application;
        $seeker = $application->user;

        if ($seeker) {
            $seeker->notify(new \App\Notifications\JobApplicationStatusUpdated($application));
        }
    }
}
