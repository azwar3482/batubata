<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerField extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'color',
        'job_titles', 'industries', 'avg_salary_min', 'avg_salary_max',
        'demand_score', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'job_titles' => 'array',
        'industries' => 'array',
        'avg_salary_min' => 'decimal:2',
        'avg_salary_max' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function paths()
    {
        return $this->hasMany(CareerPath::class, 'career_field_id')->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getDemandLabelAttribute()
    {
        if ($this->demand_score >= 80) return 'Sangat Tinggi';
        if ($this->demand_score >= 60) return 'Tinggi';
        if ($this->demand_score >= 40) return 'Sedang';
        return 'Rendah';
    }

    public function getDemandColorAttribute()
    {
        if ($this->demand_score >= 80) return 'green';
        if ($this->demand_score >= 60) return 'blue';
        if ($this->demand_score >= 40) return 'yellow';
        return 'red';
    }
}
