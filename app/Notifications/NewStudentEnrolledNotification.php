<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewStudentEnrolledNotification extends Notification
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
        $studentName = $this->enrollment->user->name ?? 'Siswa';
        $className = $this->enrollment->classRoom->name ?? 'Kelas';

        return [
            'type' => 'new_student_enrolled',
            'title' => 'Siswa Baru di Kelas Anda',
            'message' => $studentName . ' telah mendaftar ke kelas "' . $className . '".',
            'url' => route('teacher.classes.show', $this->enrollment->classRoom->id),
            'icon' => 'user-plus',
        ];
    }
}
