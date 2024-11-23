<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PcSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminPcRoomController extends Controller
{
    private $maxCapacity = 20;

    public function dashboard()
    {
        $activeSessions = PcSession::with('user')
            ->where('status', 'active')
            ->get();

        $pendingSessions = PcSession::with('user')
            ->where('status', 'pending')
            ->get();

        // Add this line for debugging
        Log::info('Active Sessions:', ['sessions' => $activeSessions->toArray()]);
        Log::info('Pending Sessions:', ['sessions' => $pendingSessions->toArray()]);

        return view('admin.pc-room.dashboard', [
            'activeSessions' => $activeSessions,
            'pendingSessions' => $pendingSessions,
            'occupancy' => $activeSessions->count(),
            'maxCapacity' => $this->maxCapacity,
            'pendingRequests' => $pendingSessions->count(),
        ]);
    }

    public function approveSession($sessionId)
    {
        $session = PcSession::find($sessionId);

        // Ensure the session exists
        if (!$session) {
            return response()->json(['message' => 'Session not found'], 404);
        }

        // Set the start and end time for the session if not already set
        $session->start_time = Carbon::now();
        $session->end_time = Carbon::now()->addHours(1); // Set the session for 1 hour (adjust as necessary)

        // Update the session status to active
        $session->update([
            'status' => 'active',
            'start_time' => now(),
            'end_time' => now()->addHours(1), // This sets the session to expire in 1 hour
        ]);

        return response()->json(['message' => 'Session approved successfully']);
    }


    public function approve($id)
    {
        try {
            $session = PcSession::findOrFail($id);

            if ($session->status !== 'pending') {
                return response()->json(['message' => 'Session is no longer pending'], 422);
            }

            $activeCount = PcSession::where('status', 'active')->count();
            if ($activeCount >= $this->maxCapacity) {
                return response()->json(['message' => 'PC Room is currently full'], 422);
            }

            // Set start time as current time and end time as 1 hour from now
            $now = Carbon::now();
            $session->update([
                'status' => 'active',
                'start_time' => $now,
                'end_time' => $now->copy()->addHour(), // Use copy() to prevent modifying $now
            ]);

            return response()->json(['message' => 'Session approved successfully']);
        } catch (\Exception $e) {
            Log::error('Session approval error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing request'], 500);
        }
    }

    public function reject($id)
    {
        try {
            $session = PcSession::findOrFail($id);
            $session->update(['status' => 'rejected']);
            return response()->json(['message' => 'Session rejected successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error rejecting session'], 500);
        }
    }

    public function endSession($id)
    {
        try {
            $session = PcSession::findOrFail($id);
            $session->update([
                'status' => 'completed',
                'end_time' => now(),
            ]);
            return response()->json(['message' => 'Session ended successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error ending session'], 500);
        }
    }
}
