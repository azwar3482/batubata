<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminQuizQuestion extends Model
{
    protected $fillable = [
        'material_id', 'question', 'options', 'correct_answer',
        'explanation', 'order_number', 'points',
    ];

    protected $casts = [
        'options' => 'array',
        'points' => 'integer',
    ];

    public function material()
    {
        return $this->belongsTo(AdminCourseMaterial::class, 'material_id');
    }
}
