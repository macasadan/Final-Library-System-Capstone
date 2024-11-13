<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;

class LostItemController extends Controller
{
    // Display list of lost items for users
    public function index()
    {
        $lostItems = LostItem::with('user')->where('status', 'lost')->latest()->get();
        return view('lost_items.index', compact('lostItems'));
    }

    // Display a specific lost item with details for users
    public function show(LostItem $lostItem)
    {
        return view('lost_items.show', compact('lostItem'));
    }
}
