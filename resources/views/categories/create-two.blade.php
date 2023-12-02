@extends('./layouts/layouts')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @section('pageCSS')
        <link rel="stylesheet" href="{{ asset('./css/categoryQuestions.css') }}"/>
    @endsection
</head>

@section('title')
    <title>Category editing question selection</title>
@endsection

@section('content')
    <div class="container">
        <div class="list-container">
            <div class="category-container">
                <div class="category-header">
                    <img src="{{ $image }}" class="category-logo">
                    <h2>{{ $name }}</h2>
                </div>
                <div class="category-questions">

                </div>
            </div>
            <div class="search-container">
                <div class="search-bar">
                    <input type="text" id="searchInput" onkeyup="" placeholder="Search...">
                </div>
                <div class="search-results">
                    @foreach($questions as $question)
                        <div class="question-container" id="{{ $question->id }}">
                            <div class="question-text">{{ $question->text }}</div>
                            <button class="actionBtn" onclick="addQuestion('{{ $question->id }}')"></button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="button-container">
            <form method="GET" action="{{ route('categories.index') }}">
                <button type="submit" class="cancel-button">CANCEL</button>
            </form>

            <form id="categoryForm" method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div id="questionIdList"></div>
                <button type="submit" class="save-button">SAVE</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/categoryQuestionSelect.js') }}"></script>
@endsection
