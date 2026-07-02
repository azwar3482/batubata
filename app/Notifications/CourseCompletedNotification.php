<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CourseCompletedNotification extends Notification
{
    use Queueable;

    protected $progress;

    public function __construct($progress)
    {
        $this->progress = $progress;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $courseTitle = $this->progress->course->title ?? 'Kursus';

        return [
            'type' => 'course_completed',
            'title' => 'Kursus Selesai!',
            'message' => 'Selamat! Anda telah menyelesaikan kursus "' . $courseTitle . '". Terus semangat belajar!',
            'url' => route('seeker.courses.my-progress'),
            'icon' => 'award',
        ];
    }
}
