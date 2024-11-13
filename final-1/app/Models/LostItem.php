<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class LostItem extends Model
{
    protected $fillable = ['user_id', 'item_type', 'description', 'date_lost', 'time_lost', 'location', 'status'];

    /**
     * Get the date lost attribute as a Carbon instance.
     *
     * @param  string  $value
     * @return \Carbon\Carbon
     */
    public function getDateLostAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
