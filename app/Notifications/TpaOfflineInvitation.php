<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TpaOfflineInvitation extends Notification
{
    use Queueable;

    protected $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'tpa_offline_invitation',
            'title' => 'Undangan Tes TPA Offline',
            'message' => 'Anda menerima undangan Tes TPA secara offline dari perusahaan. Silakan review jadwal dan lokasi tes.',
            'session_id' => $this->session->id,
            'scheduled_at' => $this->session->offline_scheduled_at?->format('d M Y H:i'),
            'location' => $this->session->offline_location,
            'action_url' => route('seeker.tpa.show', $this->session->id),
        ];
    }
}
