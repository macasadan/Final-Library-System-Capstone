<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionRoomReservation extends Model
{
    protected $fillable = [
        'user_id',
        'discussion_room_id',
        'start_time',
        'end_time',
        'purpose',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discussionRoom()
    {
        return $this->belongsTo(DiscussionRoom::class);
    }

    public function isActive()
    {
        $now = Carbon::now();
        return $this->status === 'approved' &&
               $this->start_time <= $now &&
               $this->end_time > $now;
    }

    public function isExpired()
    {
        return $this->end_time <= Carbon::now();
    }

    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
    }

    public function getStatusColorClass()
    {
        return match($this->status) {
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'completed' => 'bg-gray-100 text-gray-800',
            default => 'bg-yellow-100 text-yellow-800',
        };
    }
}