<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    protected $fillable = ['code', 'name', 'category', 'position_id', 'min_level_required', 'source_reference'];

    public function position() { return $this->belongsTo(Position::class); }
    public function scores() { return $this->hasMany(UserCompetencyScore::class); }
    public function courses() { return $this->hasMany(Course::class); }
}