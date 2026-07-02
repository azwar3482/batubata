<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InstitutionVerificationRejected extends Notification
{
    use Queueable;

    protected $institution;

    public function __construct($institution)
    {
        $this->institution = $institution;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'verification_rejected',
            'title' => 'Verifikasi Institusi Ditolak',
            'message' => 'Verifikasi institusi "' . $this->institution->name . '" ditolak. Alasan: ' . ($this->institution->rejection_reason ?? 'Tidak disebutkan') . '. Silakan perbaiki dan ajukan ulang.',
            'url' => route('education.dashboard'),
            'icon' => 'x-circle',
        ];
    }
}
