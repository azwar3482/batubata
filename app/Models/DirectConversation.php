<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirectConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'job_seeker_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function industry()
    {
        return $this->belongsTo(User::class, 'industry_id');
    }

    public function jobSeeker()
    {
        return $this->belongsTo(User::class, 'job_seeker_id');
    }

    public function messages()
    {
        return $this->hasMany(DirectMessage::class, 'conversation_id');
    }

    /**
     * Get unread messages count for a specific user in this conversation.
     *
     * @param int $userId
     * @return int
     */
    public function unreadMessagesCount($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }
}
