<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $fillable = [
        'company_id', 'user_id', 'position_id', 'external_id', 'source_platform', 'title', 'company_name', 'location', 
        'latitude', 'longitude',
        'work_type', 'salary_min', 'salary_max', 'experience_required', 
        'blood_type', 'gender', 'max_age', 'languages',
        'description', 'required_skills', 'application_url', 'posted_date', 
        'expires_date', 'is_active',
        'use_custom_weight', 'cv_weight', 'ijazah_weight', 'transkrip_weight', 'sertifikat_weight', 'portofolio_weight', 'banner_image',
        'use_tpa', 'tpa_deadline_hours'
    ];
    protected $casts = [
        'required_skills' => 'array',
        'languages' => 'array',
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
        'use_tpa' => 'boolean',
    ];

    public function applications() { return $this->hasMany(UserJobApplication::class); }
    public function position() { return $this->belongsTo(Position::class); }
    public function tpaTest() { return $this->hasOne(TpaTest::class, 'job_listing_id'); }
    public function company() { return $this->belongsTo(Company::class); }

    /**
     * Cek apakah lowongan masih tersedia untuk melamar
     */
    public function getIsAvailableAttribute(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_date && $this->expires_date->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Cek apakah TPA masih bisa diakses
     * TPA bisa diakses selama session masih aktif (undangan belum expired)
     */
    public function isTpaAccessible(): bool
    {
        // TPA bisa diakses meskipun lowongan tidak aktif
        // selama session TPA masih aktif
        return true;
    }

    /**
     * Dapatkan alasan mengapa lowongan tidak tersedia
     */
    public function getUnavailableReasonAttribute(): ?string
    {
        if (!$this->is_active) {
            return 'Lowongan ini sudah ditutup oleh perusahaan.';
        }

        if ($this->expires_date && $this->expires_date->isPast()) {
            return 'Batas waktu melamar untuk lowongan ini sudah berakhir pada ' . $this->expires_date->format('d M Y') . '.';
        }

        return null;
    }
}