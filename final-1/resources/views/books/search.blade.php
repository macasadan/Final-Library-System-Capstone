@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h2>Search Books</h2>
        <form action="{{ route('books.search') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Search by title or author" value="{{ request('query') }}" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(isset($books) && $books->count() > 0)
    <div class="row">
        @foreach($books as $book)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="card-text">
                        <strong>Author:</strong> {{ $book->author }}<br>
                        <strong>Available Copies:</strong> {{ $book->quantity }}
                    </p>
                    @if($book->quantity > 0)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#borrowModal{{ $book->id }}">
                        Borrow
                    </button>
                    @else
                    <button class="btn btn-secondary" disabled>Out of Stock</button>
                    @endif
                </div>
            </div>

            <!-- Borrow Modal -->
            <div class="modal fade" id="borrowModal{{ $book->id }}" tabindex="-1" aria-labelledby="borrowModalLabel{{ $book->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="borrowModalLabel{{ $book->id }}">Borrow "{{ $book->title }}"</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('books.borrow', $book->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="id_number{{ $book->id }}" class="form-label">ID Number</label>
                                    <input type="text" class="form-control @error('id_number') is-invalid @enderror"
                                        id="id_number{{ $book->id }}" name="id_number" required>
                                    @error('id_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="course{{ $book->id }}" class="form-label">Course</label>
                                    <input type="text" class="form-control @error('course') is-invalid @enderror"
                                        id="course{{ $book->id }}" name="course" required>
                                    @error('course')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="department{{ $book->id }}" class="form-label">Department</label>
                                    <select class="form-select @error('department') is-invalid @enderror"
                                        id="department{{ $book->id }}" name="department" required>
                                        <option value="">Select Department</option>
                                        <option value="COT">College of Technology (COT)</option>
                                        <option value="COE">College of Engineering (COE)</option>
                                        <option value="CEAS">College of Education, Arts and Sciences (CEAS)</option>
                                        <option value="CME">College of Management and Economics (CME)</option>
                                    </select>
                                    @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Confirm Borrow</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @elseif(isset($books))
    <div class="alert alert-info">
        No books found matching your search.
    </div>
    @endif
</div>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // If there were validation errors, reopen the modal
        var bookId = document.querySelector('input[name="book_id"]').value;
        var errorModal = document.querySelector('[data-bs-target="#borrowModal' + bookId + '"]');
        if (errorModal) {
            new bootstrap.Modal(document.querySelector('#borrowModal' + bookId)).show();
        }
    });
</script>
@endif
@endsection