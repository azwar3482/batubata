<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cv_text',
        'extracted_skills',
        'target_skills',
        'skill_gap',
        'gap_percentage',
        'recommendations',
    ];

    protected $casts = [
        'extracted_skills' => 'array',
        'target_skills' => 'array',
        'skill_gap' => 'array',
        'recommendations' => 'array',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
