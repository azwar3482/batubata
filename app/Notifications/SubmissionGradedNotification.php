<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubmissionGradedNotification extends Notification
{
    use Queueable;

    protected $submission;

    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $courseTitle = $this->submission->material->module->course->title ?? 'Kursus';
        $materialTitle = $this->submission->material->title ?? 'Tugas';
        $statusText = $this->submission->status === 'graded' ? 'telah dinilai' : 'memerlukan revisi';

        return [
            'type' => 'submission_graded',
            'title' => 'Tugas ' . ucfirst($statusText),
            'message' => 'Tugas "' . $materialTitle . '" di kursus ' . $courseTitle . ' ' . $statusText . '. Skor: ' . ($this->submission->score ?? '-') . '/100.',
            'url' => route('teacher.submissions.show', $this->submission->id),
            'icon' => 'clipboard-check',
        ];
    }
}
