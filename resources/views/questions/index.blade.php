@extends('./layouts/layouts')

@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/survey.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

@endsection

@section('title')
    <title>Questions list</title>
@endsection
@section('content')
    <h1 class="pageHeader">QUESTIONS</h1>
    <section class="graphSection categoryScroll" style="padding: 20px">
        <form id="createQuestionForm" method="GET" action="{{ route('questions.create') }}">
            <input type="submit" class="questionEditing" value="ADD QUESTION">
        </form>


            <div class="questionHeader" style="color: white">
                <div style="display: flex">
                    <div>#</div>
                    <div style="margin-left: 30px">Question</div>
                </div>
                <div style="display: flex">
                    <div style="margin-left: auto;  margin-right: 20px">Used In Survey</div>
                    <div style="margin-left: auto; margin-right: 20px">Edit</div>
                </div>
            </div>

            @foreach($questions as $question)
                <div class="listingQuestions">
                    <div>{{ $question->id }}</div>
                    <div style="margin-left: 20px">{{ $question->text }}</div>
                    <div style="margin-left: auto; display: flex">
                        <div style="margin-right: 40px; margin-top: 20px">{{ $question->in_survey ? 'Yes' : 'No' }}</div>
                        <div class="buttons" style="text-align: right;">
                            <form action="{{ URL::to('questions/' . $question->id . '/edit') }}">
                                <input class="questionEditing" type="submit" value="Edit" />
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
    </section>
@endsection
