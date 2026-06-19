<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminCourseMaterial extends Model
{
    protected $table = 'admin_course_materials';

    protected $fillable = [
        'chapter_id', 'title', 'type', 'content', 'external_url',
        'file_path', 'file_name', 'file_size', 'mime_type',
        'order_number', 'is_downloadable',
    ];

    protected $casts = [
        'is_downloadable' => 'boolean',
    ];

    public function chapter()
    {
        return $this->belongsTo(AdminCourseChapter::class, 'chapter_id');
    }

    public function quizQuestions()
    {
        return $this->hasMany(AdminQuizQuestion::class, 'material_id')->orderBy('order_number');
    }

    public function quizAttempts()
    {
        return $this->hasMany(AdminQuizAttempt::class, 'material_id');
    }

    public function assignmentSubmissions()
    {
        return $this->hasMany(AdminAssignmentSubmission::class, 'material_id');
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

    public function getTypeIconAttribute()
    {
        return match ($this->type) {
            'document' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            'video' => 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z',
            'link' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1',
            'text' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            'embed' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
            'assignment' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
            'quiz' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            default => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        };
    }
}
