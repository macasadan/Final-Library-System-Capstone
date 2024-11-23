@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="space-y-8">
        {{-- Header Section --}}
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Book</h1>
            <p class="mt-2 text-sm text-gray-600">Update the book's information in the library system.</p>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
        @endif

        {{-- Edit Form --}}
        <div class="bg-white rounded-lg shadow-sm">
            <form action="{{ route('admin.books.update', $book->id) }}" method="POST" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                {{-- Title Field --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        Book Title
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $book->title) }}"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-500"
                        required>
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Author Field --}}
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700">
                        Author
                    </label>
                    <input
                        type="text"
                        id="author"
                        name="author"
                        value="{{ old('author', $book->author) }}"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-500"
                        required>
                    @error('author')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Categories Field --}}
                <div>
                    <label for="category_ids" class="block text-sm font-medium text-gray-700">
                        Categories
                    </label>
                    <select
                        name="category_ids[]"
                        id="category_ids"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-500"
                        multiple
                        required>
                        @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_ids')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Published Year Field --}}
                <div>
                    <label for="published_year" class="block text-sm font-medium text-gray-700">
                        Published Year
                    </label>
                    <input
                        type="number"
                        id="published_year"
                        name="published_year"
                        value="{{ old('published_year', $book->published_year) }}"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-500"
                        required>
                    @error('published_year')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Quantity Field --}}
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">
                        Available Copies
                    </label>
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        value="{{ old('quantity', $book->quantity) }}"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-500"
                        required
                        min="0">
                    @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a
                        href="{{ route('admin.books.index') }}"
                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection