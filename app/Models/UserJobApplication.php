<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserJobApplication extends Model
{
    protected $fillable = ['user_id', 'job_listing_id', 'matching_percentage', 'applied_at', 'status', 'notes'];
    protected $casts = ['applied_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function jobListing() { return $this->belongsTo(JobListing::class); }
}