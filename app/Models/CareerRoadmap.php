<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerRoadmap extends Model
{
    protected $fillable = ['user_id', 'position_id', 'month_number', 'milestone_title', 'milestone_description', 'is_completed', 'completed_at'];
    protected $casts = ['is_completed' => 'boolean', 'completed_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function position() { return $this->belongsTo(Position::class); }
}