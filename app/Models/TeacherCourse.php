<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
    protected $fillable = [
        'teacher_id', 'competency_id', 'title', 'description', 'objectives',
        'category', 'level', 'duration_hours', 'thumbnail_path', 'status',
        'price', 'is_free', 'tags', 'max_students', 'rating', 'total_enrolled',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'tags' => 'array',
        'price' => 'decimal:2',
        'rating' => 'float',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }

    public function modules()
    {
        return $this->hasMany(CourseModule::class, 'course_id')->orderBy('order_number');
    }

    public function classes()
    {
        return $this->hasMany(TeacherClass::class, 'course_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    public function getTotalMaterialsAttribute()
    {
        return CourseMaterial::whereIn('module_id', $this->modules()->pluck('id'))->count();
    }
}
