@extends('./layouts/layouts')

@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('./css/questionEdit.css') }}"/>
@endsection

@section('title')
    <title>Question</title>
@endsection
@section('content')
    <section class="formSection">
        <h1>Edit Question</h1>
        <div class="dataHeader">Question</div>
        <input type="text" id="text" name="text" value="{{ old('text', $question->text) }}"><br>
        @error('text')
        <p style="color:red;margin-top:-5px">{{ $errors->first('text') }}</p>
        @enderror

        <div class="dataHeader">Answer type</div>
        <select id="type" name="type" onchange="toggleOptions()">
            <option value="Text" {{ old('type', $question->type) === 'Text' ? 'selected' : ''}}>Text</option>
            <option value="RadioBool" {{ old('type', $question->type) === 'RadioBool' ? 'selected' : ''}}>Yes/No</option>
            <option value="RadioGrade" {{ old('type', $question->type) === 'RadioGrade' ? 'selected' : '' }}>Numeric rating</option>
            <option value="Radio" {{ old('type', $question->type) === 'Radio' ? 'selected' : '' }}>Multiple choice (select one)</option>
            <option value="Checkbox" {{ old('type', $question->type) === 'Checkbox' ? 'selected' : '' }}>Multiple choice (select multiple)</option>
        </select><br>

        <div id="option-container" style="{{ in_array(old('type', $question->type), ['Radio', 'Checkbox']) ? '' : 'display: none;' }}">
            <div class="dataHeader">Options</div>
            <button type="button" id="add-option-btn" onclick="addOption()">Add Option</button>
            <br>
            <div id="options">
                @if(old('type') === 'Radio' || old('type') === 'Checkbox')
                    @foreach(old('options', []) as $index => $option)
                        <div class="option">
                            <input type="text" name="options[]" value="{{ $option }}" />
                            <div class="option-rmv-button" onclick="removeOption(this)"></div>
                        </div>
                        @if(empty($option))
                            <p style="color:red;margin-top:-5px">Option cannot be empty.</p>
                        @endif
                    @endforeach
                @elseif ($question->type === 'Radio' || $question->type === 'Checkbox')
                    @foreach ($question->answerChoices as $index => $answerChoice)
                        <div class="option">
                            <input type="text" name="options[]" value="{{ $answerChoice->choice_text }}">
                            @if ($index > 0)
                                <div class="option-rmv-button" onclick="removeOption(this)"></div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
            @error('options')
            <p style="color:red">{{ $message }}</p>
            @enderror
        </div>

        <div id="followUpQuestions" style="{{ in_array(old('type', $question->type), ['RadioBool', 'RadioGrade']) ? '' : 'display: none;' }}">
            <div class="dataHeader">Add follow-up questions</div>
            <div id="followUpContainer">
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search...">
                <div id="searchResults">
                    @foreach($searchableQuestions as $sQuestion)
                        <div class="following-question" id="{{ $sQuestion->id }}">
                            <div class="f-question-text">{{ $sQuestion->text }}</div>
                            <div class='fq-btn' onclick="addFollowUpQuestion('{{ $sQuestion->id }}')"></div>
                        </div>
                    @endforeach
                </div>
                <div id="selectedQuestions">
                    @foreach($followUpQuestions as $followingQuestion)
                        <div class="followup-container">
                            @php
                                $fQuestion = $followingQuestion['question'];
                                $condition = $followingQuestion['condition'];
                            @endphp
                            <div class="following-question" id="{{ $fQuestion->id }}">
                                <div class="f-question-text">{{ $fQuestion->text }}</div>
                                <div class='fq-btn' onclick="removeFollowUpQuestion('{{ $fQuestion->id }}')"></div>
                            </div>

                            <div class="condition-container">
                                <div>The above question will follow this one in the survey if the user selects:</div>
                                @if ($question->type === 'RadioBool')
                                    <div class="conditions">
                                        <select>
                                            <option value="Yes" {{ $condition === 'Yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="No" {{ $condition === 'No' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                @elseif ($question->type === 'RadioGrade')
                                    @php
                                        $conditionParts = explode(' ', $condition);
                                        $comparison = $conditionParts[0];
                                        $value = $conditionParts[1];
                                    @endphp
                                    <div class="conditions">
                                        <select>
                                            <option value="Below" {{ $comparison === 'Below' ? 'selected' : '' }}>Below</option>
                                            <option value="Above" {{ $comparison === 'Above' ? 'selected' : '' }}>Above</option>
                                        </select>
                                        <select>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ $value == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <form method="POST" action="{{route('questions.update', $question)}}">
            @csrf
            @method('PUT')
            <input type="hidden" id="hidden-text" name="text">
            <input type="hidden" id="hidden-type" name="type">
            <div id="hidden-options"></div>
            <div id="hidden-follow-ups"></div>

            <button id="action-btn" onclick="populateForm()">SAVE</button>
        </form>
    </section>
    <script src="{{ asset('js/questionEdit.js') }}"></script>
@endsection
