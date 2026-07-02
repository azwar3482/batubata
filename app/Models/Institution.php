<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'address',
        'accreditation',
        'verification_status',
        'document_statuses',
        'rejection_reason',
        'npsn_document',
        'sk_pendirian_document',
        'ktp_principal_document',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'document_statuses' => 'array',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(User::class, 'institution_id');
    }

    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }

    public function isPending()
    {
        return $this->verification_status === 'pending';
    }

    public function isRejected()
    {
        return $this->verification_status === 'rejected';
    }

    public function isUnverified()
    {
        return $this->verification_status === 'unverified';
    }

    public function getDocumentStatus($type)
    {
        $statuses = $this->document_statuses ?? [];
        return $statuses[$type]['status'] ?? 'pending';
    }

    public function getDocumentReason($type)
    {
        $statuses = $this->document_statuses ?? [];
        return $statuses[$type]['reason'] ?? null;
    }
}
