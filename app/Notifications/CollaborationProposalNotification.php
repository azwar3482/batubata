<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CollaborationProposalNotification extends Notification
{
    use Queueable;

    protected $proposal;

    public function __construct($proposal)
    {
        $this->proposal = $proposal;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'collaboration_proposal',
            'title' => 'Proposal Kolaborasi Baru',
            'message' => 'Proposal kolaborasi "' . $this->proposal->title . '" telah dikirim ke ' . $this->proposal->partner_name . '.',
            'url' => route('education.collaboration.history'),
            'icon' => 'handshake',
        ];
    }
}
