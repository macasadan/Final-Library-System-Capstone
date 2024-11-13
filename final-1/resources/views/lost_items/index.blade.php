@extends('layouts.app')

@section('content')
<h2>Lost Items</h2>

<ul>
    @foreach ($lostItems as $item)
    @if ($item->status === 'lost')
    <li>
        <h4>{{ $item->item_type }}</h4>
        <p>{{ $item->description }}</p>
        <p>Lost on {{ $item->date_lost }} at {{ $item->time_lost }} in {{ $item->location }}</p>
        <p>Status: {{ ucfirst($item->status) }}</p>
        <p>Reported by: {{ $item->user->name }}</p>
        <a href="{{ route('lost_items.show', $item) }}">View Details</a>
    </li>
    @endif
    @endforeach
</ul>
@endsection