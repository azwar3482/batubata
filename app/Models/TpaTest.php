<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpaTest extends Model
{
    protected $fillable = [
        'job_listing_id', 'created_by', 'title', 'description',
        'total_questions', 'time_limit_minutes',
        'verbal_count', 'numerik_count', 'logika_count', 'spasial_count',
        'passing_score', 'verbal_weight', 'numerik_weight', 'logika_weight', 'spasial_weight',
        'randomize_questions', 'randomize_options', 'show_result_after', 'is_active',
    ];

    protected $casts = [
        'randomize_questions' => 'boolean',
        'randomize_options' => 'boolean',
        'show_result_after' => 'boolean',
        'is_active' => 'boolean',
        'passing_score' => 'decimal:2',
        'verbal_weight' => 'decimal:2',
        'numerik_weight' => 'decimal:2',
        'logika_weight' => 'decimal:2',
        'spasial_weight' => 'decimal:2',
    ];

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class, 'job_listing_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sessions()
    {
        return $this->hasMany(TpaTestSession::class, 'tpa_test_id');
    }

    public function results()
    {
        return $this->hasMany(TpaResult::class, 'tpa_test_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForJob($query, $jobId)
    {
        return $query->where('job_listing_id', $jobId);
    }
}
