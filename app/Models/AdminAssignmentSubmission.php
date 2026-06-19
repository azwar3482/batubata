<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAssignmentSubmission extends Model
{
    protected $fillable = [
        'user_id', 'material_id', 'course_id', 'content',
        'file_path', 'file_name', 'file_size', 'status',
        'score', 'feedback', 'submitted_at', 'reviewed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
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

    public function getFileSizeFormattedAttribute()
    {
        if (!$this->file_size) return '-';
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 1) . ' ' . $units[$i];
    }
}
