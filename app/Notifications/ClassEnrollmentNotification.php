<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ClassEnrollmentNotification extends Notification
{
    use Queueable;

    protected $enrollment;

    public function __construct($enrollment)
    {
        $this->enrollment = $enrollment;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $className = $this->enrollment->classRoom->name ?? 'Kelas';
        $courseTitle = $this->enrollment->classRoom->course->title ?? 'Kursus';
        $teacherName = $this->enrollment->classRoom->teacher->name ?? 'Guru';

        return [
            'type' => 'class_enrollment',
            'title' => 'Anda Terdaftar di Kelas Baru',
            'message' => 'Anda telah didaftarkan ke kelas "' . $className . '" untuk kursus ' . $courseTitle . ' oleh ' . $teacherName . '.',
            'url' => route('teacher.classes.show', $this->enrollment->classRoom->id),
            'icon' => 'users',
        ];
    }
}
