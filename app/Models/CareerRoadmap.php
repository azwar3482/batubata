<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerRoadmap extends Model
{
    protected $fillable = ['user_id', 'position_id', 'job_listing_id', 'competency_id', 'month_number', 'milestone_title', 'milestone_description', 'priority', 'gap_percentage', 'current_level', 'target_level', 'recommended_courses', 'is_completed', 'completed_at'];
    protected $casts = ['is_completed' => 'boolean', 'completed_at' => 'datetime', 'recommended_courses' => 'array'];

    public function user() { return $this->belongsTo(User::class); }
    public function position() { return $this->belongsTo(Position::class); }
    public function jobListing() { return $this->belongsTo(JobListing::class); }
}