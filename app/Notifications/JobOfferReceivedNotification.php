<?php

namespace App\Notifications;

use App\Models\UserJobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobOfferReceivedNotification extends Notification
{
    use Queueable;

    public $application;

    /**
     * Create a new notification instance.
     */
    public function __construct(UserJobApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $jobTitle = $this->application->jobListing->title ?? 'Lowongan';
        $companyName = $this->application->jobListing->company_name ?? 'Perusahaan';

        return [
            'title' => 'Penawaran Kerja Baru',
            'message' => 'Anda menerima penawaran kerja langsung untuk posisi ' . $jobTitle . ' di ' . $companyName . '.',
            'url' => route('seeker.jobs.applications'),
            'type' => 'job_offer',
            'icon' => 'briefcase'
        ];
    }
}
