<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseVendor extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'logo',
        'website',
        'status',
    ];

    /**
     * Get the user that owns the vendor.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the teachers associated with the vendor.
     */
    public function teachers(): HasMany
    {
        return $this->hasMany(User::class, 'vendor_id')->where('role', 'teacher');
    }
}
