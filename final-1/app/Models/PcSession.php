<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PcSession extends Model
{
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'status', // pending, active, completed, rejected
        'purpose'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
