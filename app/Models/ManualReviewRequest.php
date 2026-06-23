<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManualReviewRequest extends Model
{
    protected $fillable = [
        'user_id',
        'job_listing_id',
        'status',
        'amount',
        'payment_status',
        'payment_method',
        'payment_reference',
        'user_notes',
        'admin_feedback',
        'original_score',
        'reviewed_score',
        'reviewed_by',
        'reviewed_at',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'original_score' => 'integer',
        'reviewed_score' => 'integer',
        'reviewed_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    // Constants
    const PRICE = 75000; // Rp 75.000 per review

    const STATUS_PENDING = 'pending';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_REFUNDED = 'refunded';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PAID);
    }
}
