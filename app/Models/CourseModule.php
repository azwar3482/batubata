<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    protected $fillable = [
        'course_id', 'title', 'description', 'order_number', 'duration_minutes',
    ];

    public function course()
    {
        return $this->belongsTo(TeacherCourse::class, 'course_id');
    }

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class, 'module_id')->orderBy('order_number');
    }
}
