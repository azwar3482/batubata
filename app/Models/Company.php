<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'industry',
        'size',
        'website',
    ];

    protected $casts = [
        // Tambahkan cast jika perlu
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}