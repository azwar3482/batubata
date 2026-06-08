<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpaAnswer extends Model
{
    protected $fillable = [
        'session_id', 'question_id', 'selected_answer',
        'is_correct', 'time_spent_seconds', 'is_flagged',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'is_flagged' => 'boolean',
    ];

    public function session()
    {
        return $this->belongsTo(TpaTestSession::class, 'session_id');
    }

    public function question()
    {
        return $this->belongsTo(TpaQuestion::class, 'question_id');
    }
}
