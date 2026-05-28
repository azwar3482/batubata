<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['name', 'description', 'category'];

    public function competencies() { return $this->hasMany(Competency::class); }
    public function assessments() { return $this->hasMany(UserAssessment::class); }
    public function roadmaps() { return $this->hasMany(CareerRoadmap::class); }
}
