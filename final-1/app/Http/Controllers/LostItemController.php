<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LostItemController extends Controller
{
    public function report(Request $request)
    {
        $request->validate([
            'item_type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        LostItem::create([
            'user_id' => Auth::id(),
            'item_type' => $request->item_type,
            'description' => $request->description,
            'reported_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Lost item reported successfully!');
    }
}
