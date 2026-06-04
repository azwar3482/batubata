<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title', 'description', 'provider', 'skills_covered', 'rating', 'num_reviews',
        'platform', 'category', 'competency_id', 'duration_hours', 'level',
        'url', 'price', 'is_free', 'image_url', 'created_by',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'rating' => 'float',
        'num_reviews' => 'integer',
        'duration_hours' => 'integer',
        'price' => 'decimal:2',
        'skills_covered' => 'array',
    ];

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }

    public function progress()
    {
        return $this->hasMany(UserCourseProgress::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
