<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'provider', 'skills_covered', 'rating', 'num_reviews', 'platform', 'category', 'competency_id', 'duration_hours', 'level', 'url', 'price', 'is_free'];
    protected $casts = [
        'is_free' => 'boolean',
        'rating' => 'float',
        'num_reviews' => 'integer',
        'duration_hours' => 'integer',
        'price' => 'decimal:2',
    ];

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }
    public function progress()
    {
        return $this->hasMany(UserCourseProgress::class);
    }
}
