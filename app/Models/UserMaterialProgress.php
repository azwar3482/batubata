<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMaterialProgress extends Model
{
    protected $fillable = [
        'user_id', 'material_id', 'course_id', 'is_completed', 'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(AdminCourseMaterial::class, 'material_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
