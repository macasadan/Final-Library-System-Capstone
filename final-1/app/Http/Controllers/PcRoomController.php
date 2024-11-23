<?php

namespace App\Http\Controllers;

use App\Models\PcSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PcRoomController extends Controller
{
    private $maxCapacity = 20;
    private $sessionDuration = 60;

    public function index()
    {
        $currentUserSession = PcSession::where('user_id', Auth::id())
            ->whereIn('status', ['active', 'pending'])
            ->first();

        // Expire session if end_time has passed
        if (
            $currentUserSession &&
            $currentUserSession->status === 'active' &&
            Carbon::parse($currentUserSession->end_time)->isPast()
        ) {
            $currentUserSession->update([
                'status' => 'expired',
                'end_time' => Carbon::now()
            ]);
            $currentUserSession = null; // Set to null for expired sessions
        }

        $occupancy = PcSession::where('status', 'active')->count();

        return view('pc-room.index', [
            'currentUserSession' => $currentUserSession,
            'occupancy' => $occupancy,
            'maxCapacity' => $this->maxCapacity,
        ]);
    }

    public function requestAccess(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Check for an existing session
        $existingSession = PcSession::where('user_id', Auth::id())
            ->whereIn('status', ['active', 'pending'])
            ->first();

        if ($existingSession) {
            return response()->json(['message' => 'You already have an ' . $existingSession->status . ' session'], 422);
        }

        // Additional check for room capacity, if needed
        $activeCount = PcSession::where('status', 'active')->count();
        if ($activeCount >= $this->maxCapacity) {
            return response()->json(['message' => 'PC Room is currently full'], 422);
        }

        // Create a new session
        $session = $this->createPcRoomSession($request->input('purpose'));

        return response()->json(['message' => 'Access requested successfully']);
    }

    private function createPcRoomSession($purpose)
    {
        return PcSession::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'purpose' => $purpose,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addHours(1), // Adjust as needed
        ]);
    }

    public function endSession(Request $request)
    {
        $session = PcSession::where('user_id', Auth::id())
            ->whereIn('status', ['active', 'pending'])
            ->first();

        if (!$session) {
            return response()->json(['message' => 'No active session found'], 404);
        }

        // Check if session is expired
        $isExpired = $session->status === 'active' && Carbon::parse($session->end_time)->isPast();

        if ($isExpired || $request->input('expired', false)) {
            $session->update([
                'status' => 'expired',
                'end_time' => Carbon::now()
            ]);
            return response()->json(['message' => 'Session has expired']);
        }

        $session->update([
            'status' => 'completed',
            'end_time' => Carbon::now()
        ]);

        return response()->json(['message' => 'Session ended successfully']);
    }
}
