<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DiscussionRoom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'capacity', 'status'];

    protected $appends = ['availability_status',  'occupied_until'];

    // Define the possible status values
    const STATUS_AVAILABLE = 'available';
    const STATUS_MAINTENANCE = 'maintenance';

    public function reservations()
    {
        return $this->hasMany(DiscussionRoomReservation::class);
    }

    public function getAvailabilityStatusAttribute()
    {
        // If room is in maintenance, return that status
        if ($this->status === self::STATUS_MAINTENANCE) {
            return 'maintenance';
        }

        // Check for current active reservation
        $hasActiveReservation = $this->reservations()
            ->where('status', 'approved')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('start_time', '<=', Carbon::now())
                        ->where('end_time', '>', Carbon::now());
                });
            })
            ->exists();

        return $hasActiveReservation ? 'occupied' : 'available';
    }

    public function getCurrentReservation()
    {
        return $this->reservations()
            ->where('status', 'approved')
            ->where('start_time', '<=', Carbon::now())
            ->where('end_time', '>', Carbon::now())
            ->first();
    }

    public function getStatusColorClass()
    {
        switch ($this->availability_status) {
            case 'available':
                return 'bg-green-200 text-green-800';
            case 'occupied':
                return 'bg-red-200 text-red-800';
            case 'maintenance':
                return 'bg-yellow-200 text-yellow-800';
            default:
                return 'bg-gray-200 text-gray-800';
        }
    }

    public function getStatusLabel()
    {
        switch ($this->availability_status) {
            case 'available':
                return 'Available';
            case 'occupied':
                $currentReservation = $this->getCurrentReservation();
                return $currentReservation
                    ? 'Occupied until ' . $currentReservation->end_time->format('H:i')
                    : 'Occupied';
            case 'maintenance':
                return 'Under Maintenance';
            default:
                return ucfirst($this->availability_status);
        }
    }

    public function getOccupiedUntilAttribute()
    {
        if ($this->availability_status === 'occupied') {
            $currentReservation = $this->getCurrentReservation();
            return $currentReservation ? $currentReservation->end_time : null;
        }
        return null;
    }

    public function endCurrentSession()
    {
        $currentReservation = $this->getCurrentReservation();
        if ($currentReservation) {
            $currentReservation->end_time = now();
            $currentReservation->save();
            return true;
        }
        return false;
    }
    public function isActive()
    {
        return $this->status === 'approved' &&
            now()->between($this->start_time, $this->end_time);
    }
}
