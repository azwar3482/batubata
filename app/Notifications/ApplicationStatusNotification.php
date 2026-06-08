<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification
{
    use Queueable;

    protected $application;
    protected $type;
    protected $message;

    public function __construct($application, $type, $message)
    {
        $this->application = $application;
        $this->type = $type;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $url = route('seeker.jobs.applications');

        if ($this->type === 'tpa_expired') {
            $url = route('seeker.tpa.index');
        }

        return [
            'type' => $this->type,
            'title' => $this->getTitle(),
            'message' => $this->message,
            'application_id' => $this->application->id,
            'job_title' => $this->application->jobListing->title ?? '-',
            'action_url' => $url,
        ];
    }

    protected function getTitle()
    {
        return match($this->type) {
            'application_failed' => 'Lamaran Gagal',
            'tpa_expired' => 'TPA Tidak Tersedia',
            'job_closed' => 'Lowongan Ditutup',
            'job_expired' => 'Lowongan Berakhir',
            default => 'Status Lamaran',
        };
    }
}
