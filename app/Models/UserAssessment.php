<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAssessment extends Model
{
    protected $fillable = ['user_id', 'position_id', 'assessment_date', 'total_gap_percentage', 'status'];
    protected $casts = ['assessment_date' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function position() { return $this->belongsTo(Position::class); }
    public function scores() { return $this->hasMany(UserCompetencyScore::class, 'assessment_id'); }
}