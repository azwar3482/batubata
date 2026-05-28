<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollaborationProposal extends Model
{
    protected $fillable = [
        'user_id',
        'institution_id',
        'partner_name',
        'partner_email',
        'collaboration_types',
        'title',
        'description',
        'expected_outcome',
        'timeline',
        'contact_person',
        'contact_email',
        'contact_phone',
        'attachment',
        'status',
        'rejection_reason',
        'response_at',
    ];

    protected $casts = [
        'collaboration_types' => 'array',
        'response_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
