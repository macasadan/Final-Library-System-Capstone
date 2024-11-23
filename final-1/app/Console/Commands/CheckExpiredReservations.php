<?php

namespace App\Console\Commands;

use App\Models\DiscussionRoom;
use App\Models\DiscussionRoomReservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckExpiredReservations extends Command
{
    protected $signature = 'reservations:check-expired';
    protected $description = 'Check and mark expired discussion room reservations';

    public function handle()
    {
        $this->info('Starting reservation status check...');

        // Update expired reservations
        $expiredCount = DiscussionRoomReservation::where('status', 'approved')
            ->where('end_time', '<', now())
            ->update(['status' => 'expired']);

        $this->info("Marked {$expiredCount} reservations as expired.");

        // Check current room statuses
        $rooms = DiscussionRoom::with(['reservations' => function ($query) {
            $query->where('status', 'approved')
                ->where('start_time', '<=', now())
                ->where('end_time', '>', now());
        }])->get();

        foreach ($rooms as $room) {
            $this->info("Checking room: {$room->name}");
            $this->info("Current status: {$room->availability_status}");

            if ($currentReservation = $room->getCurrentReservation()) {
                $this->info("Active reservation found:");
                $this->info("- Ends at: {$currentReservation->end_time}");
                $this->info("- User ID: {$currentReservation->user_id}");
            } else {
                $this->info("No active reservation");
            }

            // Log for debugging
            Log::info("Room {$room->name} status check", [
                'room_id' => $room->id,
                'status' => $room->availability_status,
                'has_active_reservation' => $currentReservation ? 'yes' : 'no',
                'checked_at' => now()->toDateTimeString()
            ]);
        }

        $this->info('Reservation status check completed.');
    }
}
