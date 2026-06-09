<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerPath extends Model
{
    protected $fillable = [
        'career_field_id', 'level', 'level_label',
        'year_range_min', 'year_range_max', 'description',
        'skills_required', 'certifications', 'courses',
        'salary_min', 'salary_max', 'tips', 'sort_order',
    ];

    protected $casts = [
        'skills_required' => 'array',
        'certifications' => 'array',
        'courses' => 'array',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    public function careerField()
    {
        return $this->belongsTo(CareerField::class);
    }
}
