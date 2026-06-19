<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminQuizAttempt extends Model
{
    protected $fillable = [
        'user_id', 'material_id', 'course_id', 'answers',
        'score', 'total_points', 'correct_count', 'total_questions',
        'passed', 'submitted_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'passed' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(AdminCourseMaterial::class, 'material_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
