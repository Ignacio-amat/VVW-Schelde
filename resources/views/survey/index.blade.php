@extends('./layouts/surveylayout')

@section('pageCSS')
    <link rel="stylesheet" href="{{asset('css/home.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/survey.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/index.css')}}"/>
@endsection

@section('title')
    <title>Survey</title>
@endsection

@section('content')
    <div style="width: 300%; background: #52688F; height: 20px"></div>

    <h1 id="pageHeader"></h1>

    <section class="graphSection categoryScroll">


        <div class="scrollingSection">
            <form id="surveyList" class="formBlocklist" method="POST" action="/survey">
                @csrf

                @php
                    $surveyIterator = 0;
                    $questions = [];
                @endphp

                @foreach($topiclist as $topic)
                    <div id="{{$topic->topic}}">

                        @foreach($surveyquestions as $surveyQuestion)
                            @if($surveyQuestion->topic == $topic->topic)
                                @foreach($questionlist as $question)
                                    @if($question->id == $surveyQuestion->question_id)
                                        @php
                                            array_push($questions, $question);
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        @foreach($questions as $question)
                            @if($question->in_survey === 1)
                                @php
                                    $questionID = $question->id;
                                    $questionType = $question->type;
                                    $questionText = $question->text;
                                    $questionAnswers = array();
                                    foreach ($answeroptions as $option)
                                        if ($option->question_id == $questionID)
                                            array_push($questionAnswers, $option->choice_text);
                                    $answerIterator = 0;
                                    $answerIDTag = '';
                                @endphp

                                <div id="questionID_{{$questionID}}" class="questionBlock">
                                    <h1 class="questionText overviewText">
                                        {{$questionText}}
                                        @foreach($surveyquestions as $surveyquestion)
                                            @if($surveyquestion->is_Required === 1 && $surveyquestion->question_id === $questionID)
                                                *
                                            @endif
                                        @endforeach
                                    </h1>

                                    @if ($questionType == 'Text')
                                            <?php
                                            $answerIterator++;
                                            $answerIDTag = 'Text' . $answerIterator;
                                            $questionIDTag = 'Text' . $questionID;
                                            ?>
                                        <div class="textBlock">
                                            <input type="text"
                                                   id={{$answerIDTag}}  name={{$questionIDTag}} {{old($questionIDTag)}}>

                                        </div>
                                        @error($questionIDTag)
                                        <div class="error-message alert alert-danger"
                                             style="color:red">{{ $message }}</div>
                                        @enderror

                                    @elseif ($questionType == 'Checkbox')
                                            <?php //foreach option add one block (id and for ="QuestionID" + "Iteration", name="QuestionID + Iteration" value="option value from table") ?>
                                        @foreach($questionAnswers as $Answer)
                                                <?php
                                                $answerIterator++;
                                                $answerIDTag = 'Checkbox-' . $questionID . '-' . $answerIterator;
                                                $questionIDTag = 'Checkbox' . $questionID;
                                                ?>
                                            <input type="checkbox"
                                                   id={{$answerIDTag}}  name={{$questionIDTag}} value='{{$Answer}}' {{(old($questionIDTag).'-'.$answerIterator)== $Answer? 'check' : ''}}>
                                            <label for={{$answerIDTag}}>{{ $Answer }}</label><br>
                                        @endforeach
                                        @error($questionIDTag)
                                        <div class="error-message alert alert-danger"
                                             style="color:red">{{ $message }}</div>
                                        @enderror

                                    @elseif ($questionType == 'Radio')
                                            <?php //foreach option add one block (id and for ="QuestionID" + "Iteration", name="QuestionID" value="option value from table") ?>

                                        @foreach($questionAnswers as $Answer)
                                                <?php
                                                $answerIterator++;
                                                $answerIDTag = 'Radioinputanswer' . $answerIterator;
                                                $questionIDTag = 'Radio' . $questionID;
                                                ?>

                                            <input type="radio"
                                                   id={{$answerIDTag}} name={{$questionIDTag}} value={{$Answer}} {{old($questionIDTag) == $Answer ? 'checked' : ''}}>
                                            <label for={{$answerIDTag}}>{{$Answer}}</label><br>
                                        @endforeach
                                        @error($questionIDTag)
                                        <div class="error-message alert alert-danger"
                                             style="color:red">{{ $message }}</div>
                                        @enderror

                                    @elseif ($questionType == 'RadioGrade')
                                            <?php //foreach option add one block (id and for ="QuestionID" + "Iteration", name="QuestionID" value="option value from table") ?>
                                            <?php
                                            $answerIterator++;
                                            $answerIDTag = 'Radioinputanswer' . $answerIterator;
                                            $questionIDTag = 'Radio' . $questionID;
                                            ?>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <input type="radio" id='RadioGrade{{$i}}' name="{{$questionIDTag }}"
                                                   value={{$i}} {{old($questionIDTag) == $i? 'checked' : ''}}>
                                            <label for="RadioGrade{{$i}}">{{$i}}</label>
                                        @endfor
                                        @error($questionIDTag)
                                        <div class="error-message alert alert-danger"
                                             style="color:red">{{ $message }}</div>
                                        @enderror

                                    @elseif ($questionType == 'RadioBool')
                                            <?php //foreach option add one block (id and for ="QuestionID" + "Iteration", name="QuestionID" value="option value from table") ?>
                                            <?php
                                            $answerIterator++;
                                            $answerIDTag = 'Radioinputanswer' . $answerIterator;
                                            $questionIDTag = 'Radio' . $questionID;
                                            ?>
                                        <input type="radio" id="RadioYes"
                                               name={{$questionIDTag}} value="Yes" {{old($questionIDTag) == 'Yes' ? 'checked' : ''}}>
                                        <label for="RadioYes">Yes </label>
                                        <input type="radio" id="RadioNo"
                                               name={{$questionIDTag}} value="No" {{old($questionIDTag) == 'No' ? 'checked' : ''}}>
                                        <label for="RadioNo">No </label>
                                        @error($questionIDTag)
                                        <div class="error-message alert alert-danger"
                                             style="color:red">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>

                            @endif
                        @endforeach
                    </div>
                    @php
                        $questions = [];
                    @endphp
                @endforeach

            </form>
            <div id="buttonContainer">
                <button id="backButton">Back</button>
                <button id="nextButton">Next</button>
            </div>
        </div>

        <div id="submitContainer">
        </div>
    </section>

    <script src="{{ asset('js/survey.js') }} "></script>
@endsection
