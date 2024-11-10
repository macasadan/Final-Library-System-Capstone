@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Available Books</h1>
    <ul>
        @foreach($books as $book)
        <li>
            {{ $book->title }} by {{ $book->author }}
            <p>Available Copies: {{ $book->quantity }}</p>
            <form action="{{ route('books.borrow', $book->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Borrow</button>
            </form>
        </li>
        @endforeach
    </ul>
</div>
@endsection