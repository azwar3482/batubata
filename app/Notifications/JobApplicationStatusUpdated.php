<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobApplicationStatusUpdated extends Notification
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
        $statusText = [
            'reviewed' => 'sedang direview',
            'interviewed' => 'memasuki tahap interview',
            'offered' => 'telah DITERIMA (offered)',
            'rejected' => 'telah DITOLAK',
        ][$this->application->status] ?? $this->application->status;

        return [
            'title' => 'Update Status Lamaran',
            'message' => 'Status lamaran Anda untuk posisi ' . $this->application->jobListing->title . ' di ' . $this->application->jobListing->company_name . ' ' . $statusText . '.',
            'url' => route('seeker.jobs.applications'),
            'type' => 'application_status',
            'icon' => 'clipboard-check'
        ];
    }
}
