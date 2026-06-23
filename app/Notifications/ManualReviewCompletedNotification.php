<?php

namespace App\Notifications;

use App\Models\ManualReviewRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ManualReviewCompletedNotification extends Notification
{
    use Queueable;

    protected ManualReviewRequest $reviewRequest;

    public function __construct(ManualReviewRequest $reviewRequest)
    {
        $this->reviewRequest = $reviewRequest;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Review Manual Profil Anda Selesai')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Permintaan review manual profil Anda telah selesai diproses.');

        if ($this->reviewRequest->reviewed_score !== null) {
            $mail->line("**Skor Review:** {$this->reviewRequest->reviewed_score}%");
        }

        if ($this->reviewRequest->original_score !== null) {
            $mail->line("**Skor Sebelumnya:** {$this->reviewRequest->original_score}%");
        }

        $mail->line("**Feedback dari Reviewer:**")
            ->line($this->reviewRequest->admin_feedback ?? 'Tidak ada feedback.')
            ->action('Lihat Detail', route('profile.edit'))
            ->line('Terima kasih telah menggunakan layanan review manual kami.');

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'manual_review_completed',
            'review_request_id' => $this->reviewRequest->id,
            'original_score' => $this->reviewRequest->original_score,
            'reviewed_score' => $this->reviewRequest->reviewed_score,
            'feedback' => $this->reviewRequest->admin_feedback,
        ];
    }
}
