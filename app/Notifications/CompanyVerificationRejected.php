<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CompanyVerificationRejected extends Notification
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
            'type' => 'verification_rejected',
            'title' => 'Verifikasi Perusahaan Ditolak',
            'message' => 'Verifikasi perusahaan "' . $this->company->name . '" ditolak. Alasan: ' . ($this->company->rejection_reason ?? 'Tidak disebutkan') . '. Silakan perbaiki dan ajukan ulang.',
            'url' => route('industry.dashboard'),
            'icon' => 'x-circle',
        ];
    }
}
