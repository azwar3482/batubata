<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassEnrollment extends Model
{
    protected $fillable = [
        'class_id', 'user_id', 'status', 'progress_percentage',
        'completed_modules', 'enrolled_at', 'completed_at',
        'final_score', 'notes',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function classRoom()
    {
        return $this->belongsTo(TeacherClass::class, 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCertificateCodeAttribute()
    {
        return 'BTB-' . strtoupper(substr(md5($this->id . 'batubata-salt-certificate'), 0, 10));
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'enrollment_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
