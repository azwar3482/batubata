<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherClass extends Model
{
    protected $fillable = [
        'teacher_id', 'course_id', 'name', 'code', 'description',
        'start_date', 'end_date', 'max_students', 'status',
        'meeting_link', 'schedule_info',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function course()
    {
        return $this->belongsTo(TeacherCourse::class, 'course_id');
    }

    public function enrollments()
    {
        return $this->hasMany(ClassEnrollment::class, 'class_id');
    }

    public function activeEnrollments()
    {
        return $this->hasMany(ClassEnrollment::class, 'class_id')->where('status', 'active');
    }

    public function getEnrolledCountAttribute()
    {
        return $this->enrollments()->where('status', 'active')->count();
    }

    public function getIsFullAttribute()
    {
        return $this->enrolled_count >= $this->max_students;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
