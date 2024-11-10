<form action="{{ route('books.search') }}" method="GET">
    <input type="text" name="query" placeholder="Search for books" required>
    <button type="submit">Search</button>
</form>

@if(isset($books))
<ul>
    @foreach($books as $book)
    <li>{{ $book->title }} by {{ $book->author }}</li>
    <form action="{{ route('books.borrow', $book->id) }}" method="POST">
        @csrf
        <button type="submit">Borrow</button>
    </form>
    @endforeach
</ul>
@endif