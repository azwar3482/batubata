<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TeamInvitationNotification extends Notification
{
    use Queueable;

    protected $member;
    protected $companyName;

    public function __construct($member, $companyName)
    {
        $this->member = $member;
        $this->companyName = $companyName;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'team_invitation',
            'title' => 'Undangan Tim',
            'message' => 'Anda telah diundang untuk bergabung dengan tim di "' . $this->companyName . '" sebagai ' . ucfirst(str_replace('_', ' ', $this->member->role ?? 'anggota')) . '.',
            'url' => route('industry.dashboard'),
            'icon' => 'user-plus',
        ];
    }
}
