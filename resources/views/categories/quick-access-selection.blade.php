@extends('./layouts/layouts')

@section('pageCSS')
    <link rel="stylesheet" href="{{'css/quickAccessSelection.css'}}" />
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title')
    <title>Home</title>
@endsection
@section('content')
    <h1>Select categories to the quick access menu</h1>
    <div class="categoriesGrid">
        @foreach($categories as $category)
            <div class="categoryItem">
                <p class="categoryName">{{ $category->name }}</p>
                <input class="categoryCheckBox" type="checkbox" name="categories[]" value="{{ $category->id }}" {{ $category->quickAccess ? 'checked' : '' }}>
            </div>
        @endforeach
    </div>
    <div>
        <a href="{{route('index')}}" class="button saveButton" onclick="onSavePressed()">Save</a>
        <a href="{{route('index')}}"  class="button cancelButton">Cancel</a>
    </div>
    <script src="{{'js/quickAccessCategorySelection.js'}}"></script>
@endsection
