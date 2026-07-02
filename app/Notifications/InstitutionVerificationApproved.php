<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InstitutionVerificationApproved extends Notification
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
            'type' => 'verification_approved',
            'title' => 'Verifikasi Institusi Disetujui',
            'message' => 'Selamat! Institusi "' . $this->institution->name . '" telah berhasil diverifikasi. Anda sekarang dapat menggunakan semua fitur platform.',
            'url' => route('education.dashboard'),
            'icon' => 'check-circle',
        ];
    }
}
