@extends('layouts.layouts')

<head>

    @section('pageCSS')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('./css/surveyEdit.css') }}"/>
    @endsection

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('title')
        <title>Reorder Survey Questions</title>
    @endsection

</head>

@section('content')
    <div class="container">
        <div class="list-container">
            <div class="survey-container">
                <div class="container-header">
                    SURVEY
                    @if($errors->any())
                        <div style="font-weight:normal;font-size:18px;color:red;margin:5px 0 0 0">Some topics are not filled correctly</div>
                    @endif
                </div>
                <div class="topic-list">
                    <div class="empty-topics">THE SURVEY IS EMPTY</div>
                    @if(old('topics'))
                        @foreach(old('topics', []) as $index => $topic)
                            <div class="topic-container">
                                <div class="topic">
                                    <div class="topic-handle">
                                        <div>&#9776; </div>
                                        <div>Topic*: </div>
                                        <input class="topic-title" @error('topics.' . $index . '.title') style="border-color:red" @enderror type="text" value="{{ $topic['title'] }}">
                                        @error('topics.' . $index . '.title')
                                        <div style="color:red;margin:5px 0 0 0">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button class="remove-topic-btn"></button>
                                </div>
                                <div class="topic-questions">
                                    <div class="question-list-header">
                                        <div>QUESTION</div>
                                        <div>Require response</div>
                                    </div>
                                    @error('topics.' . $index . '.questions')
                                    <div style="color:red;margin: 5px 0px 0px 20px">{{ $message }}</div>
                                    @enderror
                                    <div class="question-list">
                                        <div class="empty-questions" @error('topics.' . $index . '.questions') style="border-color:red" @enderror>
                                            DRAG QUESTIONS HERE
                                        </div>
                                        @if(isset($topic['questions']))
                                            @foreach($topic['questions'] as $question)
                                                <div class="question" id="{{ $question['id'] }}">
                                                    <div class="question-handle">{{ $question['content'] }}</div>
                                                    <div class="required-check">
                                                        <div>Required</div>
                                                        <input type="checkbox" {{ $question['is_required'] ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach($groupedQuestions as $group)
                            <div class="topic-container">
                                <div class="topic">
                                    <div class="topic-handle">
                                        <div>&#9776; </div>
                                        <div>Topic*: </div>
                                        <input class="topic-title" type="text" value="{{ $group['topic'] }}">
                                    </div>
                                    <button class="remove-topic-btn"></button>
                                </div>
                                <div class="topic-questions">
                                    <div class="question-list-header">
                                        <div>QUESTION</div>
                                        <div>Require response</div>
                                    </div>
                                    <div class="question-list">
                                        <div class="empty-questions">DRAG QUESTIONS HERE</div>
                                        @foreach($group['questions'] as $question)
                                            <div class="question" id="{{ $question->id }}">
                                                <div class="question-handle">&#9776; {{ $question->text }}</div>
                                                <div class="required-check">
                                                    <input type="checkbox" {{ $question->is_Required ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="unassigned-container">
                <div class="container-header">QUESTIONS</div>
                <div id="searchBar">
                    <input type="text" id="searchInput" onkeyup="searchQuestions()" placeholder="Search questions...">
                </div>
                <div class="unassigned-questions">
                    <div class="question-list">
                        @if(old('unassignedQuestions'))
                            @foreach(old('unassignedQuestions', []) as $question)
                                <div class="question" id="{{ $question['id'] }}">
                                    <div class="question-handle">{{ $question['content'] }}</div>
                                    <div class="required-check">
                                        <input type="checkbox">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach($unassignedQuestions as $question)
                                <div class="question" id="{{ $question->id }}">
                                    <div class="question-handle">&#9776; {{ $question->text }}</div>
                                    <div class="required-check">
                                        <input type="checkbox">
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="button-container">
            <div>
                <button id="new-topic-btn">NEW TOPIC</button>
            </div>
            <form method="POST" action="{{ route('survey.update') }}">
                @csrf
                @method('PUT')
                <div id="hiddenInputs"></div>
                <button id="save-btn" onclick="populateForm()">SAVE</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script src="{{ asset('js/editSurvey.js') }}"></script>
@endsection
