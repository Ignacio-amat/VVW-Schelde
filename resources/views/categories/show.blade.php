@extends('layouts.layouts')

@section('content')
    <div>
        <h1>Category Number:</h1>
        <p> {{ $category->id}}</p>
        <h2>Category Name:</h2>
        <p> {{ $category->name}}</p>
        <h2>Category description:</h2>
        <p> {{ $category->description}}</p>

    </div>

    <button><a href="{{ route('categories.edit', $category->id) }}">Edit Category</a></button>

    <div>
        <h1>Questions</h1>

    </div>
@endsection


