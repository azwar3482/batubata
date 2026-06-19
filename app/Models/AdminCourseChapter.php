<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminCourseChapter extends Model
{
    protected $table = 'admin_course_chapters';

    protected $fillable = [
        'course_id', 'title', 'description', 'order_number', 'duration_minutes',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function materials()
    {
        return $this->hasMany(AdminCourseMaterial::class, 'chapter_id')->orderBy('order_number');
    }
}
