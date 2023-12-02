@extends('layouts.layouts')

@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('/css/home.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/index.css') }}"/>
@endsection

@section('title')
    <title>Category List</title>
@endsection

@section('content')

    <div id="popup" class="popup">
        <h1>Are you sure you want to delete the selected categories?</h1>
        <button id="delete-yes">Yes</button>
        <button id="delete-no">No</button>
    </div>


    <div id="popup2" class="popup">
        <h1>Are you sure you want to delete the selected categories?</h1>
        <button onclick="onYesClick()">Yes</button>
        <button onclick="onNoClick()">No</button>
    </div>

    <h1 class="pageHeader">This is the list of Categories</h1>
    <div class="deleteAllDiv">
        <button class="togle-checkboxes" id="toggle-checkboxes">Select</button>
        <button id="delete-button" class="deleteAllButton delete">
            <img height="20px" width="20px" src="assets{{'/icons/index/delete.png'}}">
        </button>
    </div>
    <section id="categories" class="categoryScroll" style="padding: 20px">

        @foreach($categories as $category)
            <div class="categoryBlock">
                <div class="category-item">
                    <input type="checkbox" class="category-checkbox" value="{{ $category->id }}">
                </div>
                <div class="imagePlaceHolder">
                    <img class="image" src="{{ $category->image }}">
                </div>
                <div class="nameAndDescription">
                    <a href="/{{ $category->id }}">
                        <p class="name">{{ $category->name }}</p>
                    </a>
                    <p class="description">{{ $category->description }}</p>
                </div>
                <div class="buttons">
                    <a class="button edit" href="categories/{{ $category->id }}/edit">
                        <div class="buttonAndText">
                            <img class="editImage" src="assets{{'/icons/index/edit.png'}}">
                            Edit
                        </div>
                    </a>
                    <form method="POST" id="deleteForm{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}"
                          class="delete-form">
                        @csrf
                        @method('DELETE')
                    </form>
                    <div id="{{ $category->id }}" class="button delete" onclick="onDeleteClick('{{ $category->id }}')">
                        <div class="buttonAndText">
                            <img class="editImage" src="assets{{'/icons/index/delete.png'}}">
                            Delete
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

        <script src="{{ asset('js/selectingCheckboxes.js') }}"></script>
            <script src='js/popup.js'></script>
    </section>
@endsection
