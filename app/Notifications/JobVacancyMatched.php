<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobVacancyMatched extends Notification
{
    use Queueable;

    public $jobListing;

    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\JobListing $jobListing)
    {
        $this->jobListing = $jobListing;
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
        return [
            'title' => 'Lowongan Baru Cocok Untukmu!',
            'message' => 'Perusahaan ' . $this->jobListing->company_name . ' baru saja membuka lowongan ' . $this->jobListing->title . ' yang sesuai dengan profilmu.',
            'url' => route('seeker.jobs.detail', $this->jobListing->id),
            'type' => 'job_match',
            'icon' => 'briefcase'
        ];
    }
}
