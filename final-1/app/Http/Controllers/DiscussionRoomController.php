<?php

namespace App\Http\Controllers;

use App\Models\DiscussionRoom;
use App\Models\DiscussionRoomReservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 

class DiscussionRoomController extends Controller
{
    public function index()
    {
        $now = now();

        DiscussionRoomReservation::where('status', 'approved')
        ->where('end_time', '<=', $now)
        ->update(['status' => 'completed']);
        
        // Get all rooms with their current active reservations
        $rooms = DiscussionRoom::with(['reservations' => function ($query) use ($now) {
            $query->where('status', 'approved')
                ->where(function ($q) use ($now) {
                    $q->where('start_time', '<=', $now)
                      ->where('end_time', '>', $now);
                })
                ->with('user');
        }])->get();

        // Transform the rooms to include current reservation information
        $rooms = $rooms->map(function ($room) use ($now) {
            // Get current active reservation
            $currentReservation = $room->reservations->first();
            
            // Get upcoming reservations for today, excluding expired ones
            $upcomingReservations = DiscussionRoomReservation::where('discussion_room_id', $room->id)
    ->where('status', 'approved')
    ->where('start_time', '>', $now) // Ensure start time is in the future
    ->where('end_time', '>', $now)  // Ensure end time is also in the future
    ->where('start_time', '<', $now->copy()->endOfDay())
    ->orderBy('start_time')
    ->with('user')
    ->get();
            // Check if there's a current reservation
            $activeReservation = DiscussionRoomReservation::where('discussion_room_id', $room->id)
                ->where('status', 'approved')
                ->where('start_time', '<=', $now)
                ->where('end_time', '>', $now)
                ->with('user')
                ->first();

            $room->current_reservation = $activeReservation;
            $room->upcoming_reservations = $upcomingReservations;
            
            // Update occupied status based on current reservation or upcoming reservations
            $room->is_occupied = $activeReservation !== null || $upcomingReservations->isNotEmpty();
            
            // Set availability status
            if ($activeReservation) {
                $room->availability_status = 'occupied';
            } elseif ($upcomingReservations->isNotEmpty()) {
                $room->availability_status = 'reserved';
            } else {
                $room->availability_status = 'available';
            }
            
            return $room;
        });

        // Get the non-expired reservations for the current logged-in user
        $userId = Auth::id();
        $userReservations = DiscussionRoomReservation::where('user_id', $userId)
            ->where(function ($query) use ($now) {
                $query->where('end_time', '>', $now)
                    ->orWhere('status', 'pending');
            })
            ->with('discussionRoom')
            ->latest()
            ->get();

        $roomDropdown = $rooms->pluck('name', 'id');

        return view('reservations.index', compact('rooms', 'userReservations', 'roomDropdown'));
    }


   private function cleanupExpiredReservations($roomId, $now)
   {
       DiscussionRoomReservation::where('discussion_room_id', $roomId)
           ->where('status', 'approved')
           ->where('end_time', '<=', $now)
           ->update(['status' => 'completed']);
   }

    public function create()
    {
        $rooms = DiscussionRoom::where('status', 'available')->get();
        $roomDropdown = $rooms->pluck('name', 'id');
        return view('reservations.create', compact('roomDropdown'));
    }

    public function store(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'discussion_room_id' => 'required|exists:discussion_rooms,id',
                'start_time' => 'required|date|after:now',
                'end_time' => 'required|date|after:start_time',
                'purpose' => 'required|string|max:255',
            ]);

            // Parse times using Carbon
            $startTime = Carbon::parse($request->start_time);
            $endTime = Carbon::parse($request->end_time);

            // Check reservation duration
            if ($startTime->diffInHours($endTime) > 5) {
                return back()->withInput()->with('error', 'Reservations cannot exceed 5 hours. Please shorten your reservation.');
            }

            // Check for conflicting reservations
            $conflicting = DiscussionRoomReservation::where('discussion_room_id', $request->discussion_room_id)
            ->where('status', 'approved')
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
                });
            })->exists();

            if ($conflicting) {
                return back()->withInput()->with('error', "Room is already reserved from {$conflicting->start_time} to {$conflicting->end_time}.");
            }

            // Create reservation
            $reservation = DiscussionRoomReservation::create([
                'user_id' => Auth::id(),
                'discussion_room_id' => $request->discussion_room_id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'purpose' => $request->purpose,
                'status' => 'pending'
            ]);

            return redirect()->route('reservations.index')->with('success', 'Reservation request submitted successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Reservation creation error: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


    // New method for checking room availability in real-time
    public function checkRoomAvailability(Request $request)
    {
        try {
            $roomId = $request->input('room_id');
            $startTime = Carbon::parse($request->input('start_time'));
            $endTime = Carbon::parse($request->input('end_time'));

            // Check for conflicting reservations
            $conflicting = DiscussionRoomReservation::where('discussion_room_id', $roomId)
                ->where('status', 'approved')
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime]);
                })->exists();

            return response()->json([
                'is_available' => !$conflicting,
                'start_time' => $startTime->toDateTimeString(),
                'end_time' => $endTime->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            Log::error('Availability check error: ' . $e->getMessage());
            
            return response()->json([
                'is_available' => false,
                'error' => 'Error checking availability'
            ], 400);
        }
    }

    // New method for manual session end
    public function endSession(DiscussionRoomReservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $reservation->end_time = now();
        $reservation->save();

        return back()->with('success', 'Session ended successfully.');
    }
}
