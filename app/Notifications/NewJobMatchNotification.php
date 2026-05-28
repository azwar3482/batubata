<?php

namespace App\Notifications;

use App\Models\JobListing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobMatchNotification extends Notification
{
    use Queueable;

    protected $job;
    protected $matchPercentage;

    public function __construct(JobListing $job, float $matchPercentage)
    {
        $this->job = $job;
        $this->matchPercentage = $matchPercentage;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // Kirim via Email dan Simpan di DB
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('🎉 Lowongan Baru Cocok Dengan Profil Anda!')
                    ->greeting('Halo ' . $notifiable->name . '!')
                    ->line('Kami menemukan lowongan kerja yang sangat cocok dengan skill Anda.')
                    ->line('Posisi: **' . $this->job->title . '** di ' . $this->job->company_name)
                    ->line('Tingkat Kecocokan: **' . $this->matchPercentage . '%**')
                    ->action('Lihat Lowongan', url('/jobs/' . $this->job->id))
                    ->line('Terus semangat belajar di KompasKarir!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'job_id' => $this->job->id,
            'title' => $this->job->title,
            'company' => $this->job->company_name,
            'match_percentage' => $this->matchPercentage,
            'message' => 'Lowongan baru cocok dengan profil Anda (' . $this->matchPercentage . '%)',
        ];
    }
}