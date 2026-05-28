<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCompetencyScore extends Model
{
    protected $fillable = ['assessment_id', 'competency_id', 'self_assessed_level', 'ai_analyzed_level', 'gap_percentage', 'priority'];
    // app/Models/UserCompetencyScore.php
    public function assessment()
    {
        return $this->belongsTo(UserAssessment::class, 'assessment_id');
    }

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }
}
