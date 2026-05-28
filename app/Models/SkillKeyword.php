<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillKeyword extends Model
{
    protected $fillable = ['category', 'keyword', 'is_active'];
}
