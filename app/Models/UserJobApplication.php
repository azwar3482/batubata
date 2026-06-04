<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserJobApplication extends Model
{
    protected $fillable = [
        'user_id', 'job_listing_id', 'matching_percentage', 'applied_at', 'status', 'notes',
        'is_direct_offer', 'direct_offer_status'
    ];
    protected $casts = [
        'applied_at' => 'datetime',
        'is_direct_offer' => 'boolean'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function jobListing() { return $this->belongsTo(JobListing::class); }
}