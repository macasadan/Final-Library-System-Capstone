<?php

namespace App\Http\Controllers;

use App\Models\DiscussionRoom;
use App\Models\DiscussionRoomReservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DiscussionRoomController extends Controller
{
    public function index()
    {
        // Get all available discussion rooms
        $rooms = DiscussionRoom::all();

        // Get the reservations for the current logged-in user
        $userId = auth()->id();
        $userReservations = DiscussionRoomReservation::where('user_id', $userId)
            ->with('discussionRoom')
            ->latest()
            ->get();

        return view('reservations.index', compact('rooms', 'userReservations'));
    }

    public function create()
    {
        $rooms = DiscussionRoom::all();
        return view('reservations.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'discussion_room_id' => 'required|exists:discussion_rooms,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'purpose' => 'required|string|max:255',
        ]);

        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);

        // Check if duration is not more than 5 hours
        if ($startTime->diffInHours($endTime) > 5) {
            return back()->with('error', 'Reservation duration cannot exceed 5 hours.');
        }

        // Check for conflicting reservations
        $conflicting = DiscussionRoomReservation::where('discussion_room_id', $request->discussion_room_id)
            ->where('status', 'approved')
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })->exists();

        if ($conflicting) {
            return back()->with('error', 'The room is already reserved for this time slot.');
        }

        $reservation = DiscussionRoomReservation::create([
            'user_id' => auth()->id(),
            'discussion_room_id' => $request->discussion_room_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
            'status' => 'pending'
        ]);

        // Check if the reservation has already expired
        if ($reservation->isExpired()) {
            $reservation->markAsExpired();
        }
        return redirect()->route('reservations.index')->with('success', 'Reservation request submitted successfully.');
    }

    public function updateStatus($id, Request $request)
    {
        // Fetch the discussion room by ID
        $room = DiscussionRoom::findOrFail($id);

        // Update the status with the requested status (e.g., active, inactive)
        $room->status = $request->input('status');
        $room->save();

        // Redirect back with a success message
        return redirect()->route('admin.dashboard')->with('success', 'Room status updated successfully.');
    }
}
