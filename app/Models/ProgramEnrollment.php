<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramEnrollment extends Model
{
    protected $fillable = [
        'program_id', 'user_id', 'status', 'enrolled_at',
        'completed_at', 'progress_percentage', 'notes',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress_percentage' => 'integer',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
