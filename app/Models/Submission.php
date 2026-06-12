<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'enrollment_id', 'material_id', 'content', 'file_path',
        'file_name', 'file_size', 'status', 'score', 'feedback',
        'submitted_at', 'graded_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
    ];

    public function enrollment()
    {
        return $this->belongsTo(ClassEnrollment::class, 'enrollment_id');
    }

    public function material()
    {
        return $this->belongsTo(CourseMaterial::class, 'material_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeGraded($query)
    {
        return $query->where('status', 'graded');
    }
}
