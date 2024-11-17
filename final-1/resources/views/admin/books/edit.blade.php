<!-- resources/views/admin/books/edit.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Book</h1>

    <form action="{{ route('admin.books.update', $book->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required>
        </div>

        <div>
            <label for="category_ids" class="block text-sm font-medium text-gray-700">Categories</label>
            <select name="category_ids[]" id="category_ids" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" multiple required>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="author">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="{{ $book->author }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="published_year">Published Year</label>
            <input type="number" class="form-control" id="published_year" name="published_year" value="{{ $book->published_year }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Book</button>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection