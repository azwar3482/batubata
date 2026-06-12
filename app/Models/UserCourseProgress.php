<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourseProgress extends Model
{
    protected $fillable = ['user_id', 'course_id', 'status', 'started_at', 'completed_at', 'progress_percentage'];
    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress_percentage' => 'float',
        'completed_modules' => 'integer',
        'total_modules' => 'integer',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function course() { return $this->belongsTo(Course::class); }

    public function getCertificateCodeAttribute()
    {
        return 'BTB-P-' . strtoupper(substr(md5($this->id . 'batubata-salt-platform-certificate'), 0, 10));
    }
}