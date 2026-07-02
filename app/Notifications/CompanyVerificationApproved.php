<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CompanyVerificationApproved extends Notification
{
    use Queueable;

    protected $company;

    public function __construct($company)
    {
        $this->company = $company;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'verification_approved',
            'title' => 'Verifikasi Perusahaan Disetujui',
            'message' => 'Selamat! Perusahaan "' . $this->company->name . '" telah berhasil diverifikasi. Anda sekarang dapat menggunakan semua fitur platform.',
            'url' => route('industry.dashboard'),
            'icon' => 'check-circle',
        ];
    }
}
