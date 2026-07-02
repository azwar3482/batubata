<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewJobApplicationNotification extends Notification
{
    use Queueable;

    protected $application;

    public function __construct($application)
    {
        $this->application = $application;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $applicantName = $this->application->user->name ?? 'Kandidat';
        $jobTitle = $this->application->jobListing->title ?? 'Lowongan';

        return [
            'type' => 'new_application',
            'title' => 'Lamaran Baru Diterima',
            'message' => $applicantName . ' telah melamar untuk posisi "' . $jobTitle . '".',
            'url' => route('industry.candidates.show', $this->application->id),
            'icon' => 'inbox',
        ];
    }
}
