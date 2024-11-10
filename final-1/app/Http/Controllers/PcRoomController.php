<?php

namespace App\Http\Controllers;

use App\Models\PCRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PCRoomController extends Controller
{
    public function reserve(Request $request, $room_id)
    {
        $reservation = PCRoom::create([
            'user_id' => Auth::id(),
            'pc_room_id' => $room_id,
            'reserved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'PC room reserved successfully!');
    }
}
