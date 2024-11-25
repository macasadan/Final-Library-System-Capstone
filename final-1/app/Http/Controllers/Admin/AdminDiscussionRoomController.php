<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscussionRoom;
use App\Models\DiscussionRoomReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class AdminDiscussionRoomController extends Controller
{
    // Display list of discussion rooms and pending/expired reservations
    public function index()
    {
        // Fetch all rooms with reservation status for 'available' or 'not available' based on current reservations
        $rooms = DiscussionRoom::with(['reservations' => function ($query) {
            $query->where('status', 'approved')
                ->where(function ($q) {
                    $q->where('start_time', '<=', Carbon::now())
                        ->where('end_time', '>', Carbon::now());
                });
        }])->get();

        // Update each room's status based on reservations
        foreach ($rooms as $room) {
            Log::info("Room {$room->name} - Base Status: {$room->status}, Availability: {$room->availability_status}");
            if ($room->availability_status === 'occupied') {
                $currentReservation = $room->getCurrentReservation();
                Log::info("Current reservation ends at: " . $currentReservation->end_time);
            }
        }

        // Fetch pending reservations for admin view
        $pendingReservations = DiscussionRoomReservation::where('status', 'pending')
            ->with(['user', 'discussionRoom'])
            ->latest()
            ->get();

        // Count expired reservations
        $expiredReservations = DiscussionRoomReservation::where('status', 'approved')
            ->where('end_time', '<', now())
            ->count();

        // Create dropdown for admin if needed
        $roomDropdown = $rooms->pluck('name', 'id');

        return view('admin.discussion_rooms.index', compact(
            'rooms',
            'pendingReservations',
            'expiredReservations',
            'roomDropdown'
        ));
    }


    // Show the form for creating a new discussion room
    public function create()
    {
        return view('admin.discussion_rooms.create');
    }

    // Store a newly created discussion room in the database
    public function store(Request $request)
    {
        // Validate the room input
        $request->validate([
            'name' => 'required|string|max:255|unique:discussion_rooms,name',
            'capacity' => 'required|integer|min:1',
        ]);

        // Create a new discussion room
        DiscussionRoom::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
        ]);

        // Redirect back to the rooms index with a success message
        return redirect()->route('admin.discussion_rooms.index')
            ->with('success', 'Discussion room created successfully.');
    }

    // Update the reservation status (approved or rejected)
    public function updateStatus(Request $request, DiscussionRoom $room)
    {
        $request->validate([
            'status' => 'required|in:available,maintenance'
        ]);

        $room->update(['status' => $request->status]);

        return back()->with('success', 'Room status updated successfully.');
    }

    public function updateReservationStatus(Request $request, DiscussionRoomReservation $reservation)
    {
        try {
            // Validate the request
            $request->validate([
                'status' => 'required|in:approved,rejected'
            ]);

            // Update the reservation status
            $reservation->status = $request->status;
            $reservation->save();

            // If approved, check for conflicting reservations
            if ($request->status === 'approved') {
                // Check for other approved reservations that might conflict
                $conflictingReservations = DiscussionRoomReservation::where('discussion_room_id', $reservation->discussion_room_id)
                    ->where('id', '!=', $reservation->id)
                    ->where('status', 'approved')
                    ->where(function ($query) use ($reservation) {
                        $query->whereBetween('start_time', [$reservation->start_time, $reservation->end_time])
                            ->orWhereBetween('end_time', [$reservation->start_time, $reservation->end_time]);
                    })->exists();

                // If conflicts exist, mark as rejected and return with error
                if ($conflictingReservations && $request->status === 'approved') {
                    return back()->with('error', 'Cannot approve reservation due to time slot conflict.');
                }

                $reservation->update(['status' => $request->status]);

                return back()->with('success', 'Reservation status updated successfully.');

                // Log the approval
                Log::info("Reservation {$reservation->id} approved for room {$reservation->discussion_room_id}");
            }

            // Return success message based on status
            $message = $request->status === 'approved'
                ? 'Reservation approved successfully.'
                : 'Reservation rejected successfully.';

            return redirect()->route('admin.discussion_rooms.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error("Error updating reservation status: " . $e->getMessage());
            return redirect()->route('admin.discussion_rooms.index')
                ->with('error', 'An error occurred while processing the reservation.');
        }
    }

    public function updateRoomStatus(Request $request, DiscussionRoom $room)
    {
        $request->validate([
            'status' => 'required|in:available,maintenance'
        ]);

        $room->update(['status' => $request->status]);

        return back()->with('success', 'Room status updated successfully.');
    }

    // Add new method to end session
    public function endSession(DiscussionRoom $room)
    {
        try {
            if ($room->endCurrentSession()) {
                return redirect()->back()->with('success', 'Room session ended successfully.');
            }
            return redirect()->back()->with('error', 'No active session to end.');
        } catch (\Exception $e) {
            Log::error("Error ending room session: " . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while ending the session.');
        }
    }

    // Display list of expired reservations
    public function expired()
    {
        $expiredReservations = DiscussionRoomReservation::where('status', 'approved')
            ->where('end_time', '<', now())
            ->with(['user', 'discussionRoom'])
            ->latest()
            ->get();

        return view('admin.discussion_rooms.expired', compact('expiredReservations'));
    }
    public function history()
{
    $reservations = DiscussionRoomReservation::with(['user', 'discussionRoom'])
        ->orderBy('created_at', 'desc')
        ->paginate(15); // Paginate results for better performance

    // Get statistics for the dashboard
    $stats = [
        'total_reservations' => DiscussionRoomReservation::count(),
        'approved_count' => DiscussionRoomReservation::where('status', 'approved')->count(),
        'rejected_count' => DiscussionRoomReservation::where('status', 'rejected')->count(),
        'pending_count' => DiscussionRoomReservation::where('status', 'pending')->count(),
    ];

    return view('admin.discussion_rooms.history', compact('reservations', 'stats'));
}
}
