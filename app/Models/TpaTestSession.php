<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpaTestSession extends Model
{
    protected $fillable = [
        'tpa_test_id', 'user_id', 'job_application_id', 'status',
        'tpa_type', 'offline_instructions', 'offline_scheduled_at',
        'offline_location', 'offline_contact_person', 'offline_contact_phone',
        'offline_notes', 'seeker_response', 'reschedule_proposed_at',
        'reschedule_reason', 'offline_score', 'offline_is_passed', 'offline_result_notes',
        'started_at', 'completed_at', 'expires_at',
        'time_spent_seconds', 'question_order',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'expires_at' => 'datetime',
        'offline_scheduled_at' => 'datetime',
        'reschedule_proposed_at' => 'datetime',
        'question_order' => 'array',
        'offline_is_passed' => 'boolean',
    ];

    public function tpaTest()
    {
        return $this->belongsTo(TpaTest::class, 'tpa_test_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobApplication()
    {
        return $this->belongsTo(UserJobApplication::class, 'job_application_id');
    }

    public function answers()
    {
        return $this->hasMany(TpaAnswer::class, 'session_id');
    }

    public function result()
    {
        return $this->hasOne(TpaResult::class, 'session_id');
    }

    public function scopeInvited($query)
    {
        return $query->where('status', 'invited');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'in_progress';
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getRemainingTimeSecondsAttribute()
    {
        if (!$this->started_at) {
            return $this->tpaTest->time_limit_minutes * 60;
        }

        $elapsed = (int) abs($this->started_at->diffInSeconds(now()));
        $limit = $this->tpaTest->time_limit_minutes * 60;
        $remaining = $limit - $elapsed - $this->time_spent_seconds;

        return max(0, $remaining);
    }
}
