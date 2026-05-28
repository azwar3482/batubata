<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $fillable = [
        'company_id', 'user_id', 'external_id', 'source_platform', 'title', 'company_name', 'location', 
        'latitude', 'longitude',
        'work_type', 'salary_min', 'salary_max', 'experience_required', 
        'description', 'required_skills', 'application_url', 'posted_date', 
        'expires_date', 'is_active',
        'use_custom_weight', 'cv_weight', 'ijazah_weight', 'transkrip_weight', 'sertifikat_weight', 'portofolio_weight', 'banner_image'
    ];
    protected $casts = [
        'required_skills' => 'array',
        'posted_date' => 'date',
        'expires_date' => 'date',
        'is_active' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'use_custom_weight' => 'boolean',
        'cv_weight' => 'decimal:2',
        'ijazah_weight' => 'decimal:2',
        'transkrip_weight' => 'decimal:2',
        'sertifikat_weight' => 'decimal:2',
        'portofolio_weight' => 'decimal:2',
    ];

    public function applications() { return $this->hasMany(UserJobApplication::class); }
}