<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PCRoom extends Model
{
    protected $fillable = ['room_name', 'availability'];

    public function reservations()
    {
        return $this->hasMany(PCRoom::class);
    }
}
