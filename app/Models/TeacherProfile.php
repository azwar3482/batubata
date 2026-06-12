<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{
    protected $fillable = [
        'user_id', 'specialization', 'bio', 'qualification',
        'institution_name', 'avatar_path', 'experience_years',
        'expertise_areas', 'linkedin_url', 'is_verified',
    ];

    protected $casts = [
        'expertise_areas' => 'array',
        'is_verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
