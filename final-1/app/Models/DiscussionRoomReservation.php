<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionRoomReservation extends Model
{
    protected $fillable = [
        'user_id',
        'discussion_room_id',
        'start_time',
        'end_time',
        'status', // pending, approved, rejected, expired
        'purpose'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function discussionRoom(): BelongsTo
    {
        return $this->belongsTo(DiscussionRoom::class);
    }

    public function isExpired(): bool
    {
        if ($this->end_time < now()) {
            $this->markAsExpired();
            return true;
        }
        return false;
    }

    public function markAsExpired()
    {
        $this->status = 'expired';
        $this->save();
    }
}
