<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpaResult extends Model
{
    protected $fillable = [
        'session_id', 'user_id', 'tpa_test_id',
        'verbal_score', 'numerik_score', 'logika_score', 'spasial_score',
        'total_score', 'bappenas_score',
        'total_correct', 'total_wrong', 'total_unanswered', 'total_questions',
        'is_passed', 'passing_score',
    ];

    protected $casts = [
        'verbal_score' => 'decimal:2',
        'numerik_score' => 'decimal:2',
        'logika_score' => 'decimal:2',
        'spasial_score' => 'decimal:2',
        'total_score' => 'decimal:2',
        'passing_score' => 'decimal:2',
        'is_passed' => 'boolean',
    ];

    public function session()
    {
        return $this->belongsTo(TpaTestSession::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tpaTest()
    {
        return $this->belongsTo(TpaTest::class, 'tpa_test_id');
    }

    public function getScoreGradeAttribute()
    {
        if ($this->bappenas_score >= 700) return 'Sangat Baik';
        if ($this->bappenas_score >= 600) return 'Baik';
        if ($this->bappenas_score >= 500) return 'Cukup';
        if ($this->bappenas_score >= 400) return 'Kurang';
        return 'Sangat Kurang';
    }
}
