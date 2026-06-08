<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpaQuestion extends Model
{
    protected $fillable = [
        'category', 'subcategory', 'difficulty', 'question_text',
        'question_image', 'options', 'correct_answer', 'explanation',
        'is_active', 'created_by',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function answers()
    {
        return $this->hasMany(TpaAnswer::class, 'question_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    public function getCategoryLabelAttribute()
    {
        return match ($this->category) {
            'verbal' => 'Verbal',
            'numerik' => 'Numerik',
            'logika' => 'Logika',
            'spasial' => 'Spasial',
            default => $this->category,
        };
    }

    public function getDifficultyLabelAttribute()
    {
        return match ($this->difficulty) {
            'easy' => 'Mudah',
            'medium' => 'Sedang',
            'hard' => 'Sulit',
            default => $this->difficulty,
        };
    }
}
