@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Lost Item Details</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $lostItem->item_type }}</h2>
        <p>{{ $lostItem->description }}</p>
        <p>Lost on {{ $lostItem->date_lost->format('F j, Y') }} at {{ $lostItem->time_lost }} in {{ $lostItem->location }}</p>
        <p>Status: {{ ucfirst($lostItem->status) }}</p>
        <p>Reported by: {{ $lostItem->user->name }}</p>
    </div>
</div>
@endsection