@extends('layouts.app')

@section('content')
<div id="react-book-category"
    data-category="{{ json_encode($category) }}"
    data-books="{{ json_encode($books) }}">
</div>
@endsection