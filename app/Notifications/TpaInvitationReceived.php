<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TpaInvitationReceived extends Notification
{
    use Queueable;

    protected $session;
    protected $test;

    public function __construct($session, $test)
    {
        $this->session = $session;
        $this->test = $test;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'tpa_invitation',
            'title' => 'Undangan Tes TPA',
            'message' => 'Anda menerima undangan Tes Potensi Akademik dari perusahaan. Segera kerjakan tes sebelum batas waktu berakhir.',
            'session_id' => $this->session->id,
            'test_title' => $this->test->title,
            'total_questions' => $this->test->total_questions,
            'time_limit' => $this->test->time_limit_minutes . ' menit',
            'expires_at' => $this->session->expires_at?->format('d M Y H:i'),
            'action_url' => route('seeker.tpa.show', $this->session->id),
        ];
    }
}
