<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['content', 'author', 'category', 'is_active'];

    public static function getRandom()
    {
        return static::where('is_active', true)->inRandomOrder()->first();
    }
}
