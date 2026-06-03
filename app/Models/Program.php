<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name', 'type', 'description', 'duration', 'max_students',
        'status', 'start_date', 'end_date', 'institution_id',
        'industry_partners', 'curriculum_path',
    ];

    protected $casts = [
        'industry_partners' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function enrollments()
    {
        return $this->hasMany(ProgramEnrollment::class);
    }

    public function getEnrolledCountAttribute()
    {
        return $this->enrollments()->count();
    }
}
