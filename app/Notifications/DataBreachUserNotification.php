<?php

namespace App\Notifications;

use App\Models\SecurityLog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DataBreachUserNotification extends Notification
{
    use Queueable;

    protected SecurityLog $securityLog;

    public function __construct(SecurityLog $securityLog)
    {
        $this->securityLog = $securityLog;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Peringatan Keamanan Akun Anda - KOMPASKARIR')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Kami mendeteksi aktivitas mencurigakan pada akun Anda.');

        // Customize message based on event type
        switch ($this->securityLog->event_type) {
            case SecurityLog::EVENT_SUSPICIOUS_LOGIN:
                $mail->line('**Aktivitas:** Login dari perangkat/lokasi baru yang tidak dikenal.')
                     ->line('**IP Address:** ' . $this->securityLog->ip_address)
                     ->line('Jika ini Anda, tidak perlu melakukan apa-apa. Jika bukan, segera ubah kata sandi Anda.');
                break;
            case SecurityLog::EVENT_BRUTE_FORCE:
                $mail->line('**Aktivitas:** Percobaan login berulang yang gagal ke akun Anda.')
                     ->line('Kami telah memblokir percobaan ini untuk melindungi akun Anda.')
                     ->line('Disarankan untuk segera mengubah kata sandi Anda.');
                break;
            case SecurityLog::EVENT_ACCOUNT_TAKEOVER:
                $mail->line('**Aktivitas:** Aktivitas tidak biasa yang mengindikasikan akun Anda mungkin telah dikompromikan.')
                     ->line('**SEGERA** ubah kata sandi Anda dan periksa aktivitas akun.');
                break;
            default:
                $mail->line('**Aktivitas:** ' . $this->securityLog->description)
                     ->line('Sebagai tindakan pencegahan, disarankan untuk mengubah kata sandi Anda.');
        }

        $mail->line('---')
             ->line('**Langkah yang disarankan:**')
             ->line('1. Segera ubah kata sandi Anda')
             ->line('2. Aktifkan autentikasi dua faktor jika tersedia')
             ->line('3. Periksa aktivitas akun terakhir Anda')
             ->line('4. Hubungi kami jika Anda melihat aktivitas mencurigakan')
             ->action('Ubah Kata Sandi', route('profile.edit'))
             ->line('---')
             ->line('Jika Anda tidak mengenali aktivitas ini, segera hubungi kami di privacy@kompaskarir.id');

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'data_breach_alert',
            'security_log_id' => $this->securityLog->id,
            'event_type' => $this->securityLog->event_type,
            'severity' => $this->securityLog->severity,
            'description' => $this->securityLog->description,
            'ip_address' => $this->securityLog->ip_address,
        ];
    }
}
