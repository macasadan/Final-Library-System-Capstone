<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    protected $fillable = ['user_id', 'item_type', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
