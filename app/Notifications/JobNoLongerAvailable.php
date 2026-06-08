<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class JobNoLongerAvailable extends Notification
{
    use Queueable;

    protected $jobListing;
    protected $reason;

    public function __construct($jobListing, $reason = null)
    {
        $this->jobListing = $jobListing;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'job_unavailable',
            'title' => 'Lowongan Tidak Tersedia',
            'message' => $this->reason ?? 'Lowongan "' . $this->jobListing->title . '" sudah tidak tersedia.',
            'job_id' => $this->jobListing->id,
            'job_title' => $this->jobListing->title,
            'action_url' => route('seeker.jobs.index'),
        ];
    }
}
