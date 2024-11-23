<?php

namespace App\Http\Controllers;

use App\Models\DiscussionRoom;
use App\Models\DiscussionRoomReservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DiscussionRoomController extends Controller
{
    public function index()
    {
        // Get all available discussion rooms
        $rooms = DiscussionRoom::all();

        // Get the reservations for the current logged-in user
        $userId = Auth::id();
        $userReservations = DiscussionRoomReservation::where('user_id', $userId)
            ->with('discussionRoom')
            ->latest()
            ->get();

        // Add a dropdown list of rooms
        $availableRooms = $rooms->where('status', 'available');
        $roomDropdown = $rooms->pluck('name', 'id');

        return view('reservations.index', compact('rooms', 'userReservations', 'roomDropdown'));
    }

    public function create()
    {
        $rooms = DiscussionRoom::where('status', 'available')->get();
        $roomDropdown = $rooms->pluck('name', 'id');
        return view('reservations.create', compact('roomDropdown'));
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
            'user_id' => Auth::id(),
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

    // New method for checking room availability in real-time
    public function checkRoomAvailability(Request $request)
    {
        $roomId = $request->input('room_id');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        $conflicting = DiscussionRoomReservation::where('discussion_room_id', $roomId)
            ->where('status', 'approved')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime]);
            })->exists();

        return response()->json([
            'is_available' => !$conflicting
        ]);
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
