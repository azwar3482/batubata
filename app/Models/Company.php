<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'industry',
        'size',
        'website',
        'verification_status',
        'nib_document',
        'siup_document',
        'npwp_document',
        'ktp_director_document',
        'verified_at',
        'verified_by',
        'rejection_reason',
        'document_statuses',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'document_statuses' => 'array',
    ];

    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }

    public function isPending()
    {
        return $this->verification_status === 'pending';
    }

    public function isUnverified()
    {
        return $this->verification_status === 'unverified';
    }

    public function isRejected()
    {
        return $this->verification_status === 'rejected';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }

    public function getDocumentStatus($type)
    {
        return $this->document_statuses[$type]['status'] ?? 'pending';
    }

    public function getDocumentReason($type)
    {
        return $this->document_statuses[$type]['reason'] ?? null;
    }
}