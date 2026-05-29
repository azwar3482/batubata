<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobApplicationWithdrawn extends Notification
{
    use Queueable;

    public $application;

    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\UserJobApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $applicantName = $this->application->user ? $this->application->user->name : 'Seorang kandidat';

        return [
            'title' => 'Pelamar Membatalkan Lamaran',
            'message' => $applicantName . ' telah membatalkan lamarannya untuk posisi ' . $this->application->jobListing->title . '.',
            'url' => route('industry.candidates'),
            'type' => 'application_withdrawn',
            'icon' => 'user-minus'
        ];
    }
}
