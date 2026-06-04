<?php

namespace App\Notifications;

use App\Models\UserJobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobOfferResponseNotification extends Notification
{
    use Queueable;

    public $application;
    public $response;

    /**
     * Create a new notification instance.
     */
    public function __construct(UserJobApplication $application, string $response)
    {
        $this->application = $application;
        $this->response = $response;
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
        $candidateName = $this->application->user->name ?? 'Kandidat';
        $responseWord = $this->response === 'accepted' ? 'MENERIMA' : 'MENOLAK';

        return [
            'title' => 'Respon Penawaran Kerja',
            'message' => $candidateName . ' telah ' . $responseWord . ' penawaran kerja untuk posisi ' . $jobTitle . '.',
            'url' => route('industry.jobs.show', $this->application->job_listing_id),
            'type' => 'offer_response',
            'icon' => $this->response === 'accepted' ? 'clipboard-check' : 'user-minus'
        ];
    }
}
