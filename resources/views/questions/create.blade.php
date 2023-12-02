@extends('./layouts/layouts')

@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('./css/questionEdit.css') }}"/>
@endsection

@section('title')
    <title>Question</title>
@endsection

@section('content')
    <section class="formSection">
        <h1>Create Question</h1>
        <div class="dataHeader">Question</div>
        <input type="text" id="text" name="text" value="{{ old('text') }}">
        @error('text')
        <p style="color:red;margin-top:-5px">{{ $message }}</p>
        @enderror

        <div class="dataHeader">Answer type</div>
        <select id="type" name="type" onchange="toggleOptions()">
            <option value="Text" {{ old('type') === 'Text' ? 'selected' : '' }}>Text</option>
            <option value="RadioBool" {{ old('type') === 'RadioBool' ? 'selected' : '' }}>Yes/No</option>
            <option value="RadioGrade" {{ old('type') === 'RadioGrade' ? 'selected' : '' }}>Numeric rating</option>
            <option value="Radio" {{ old('type') === 'Radio' ? 'selected' : '' }}>Multiple choice (select one)</option>
            <option value="Checkbox" {{ old('type') === 'Checkbox' ? 'selected' : '' }}>Multiple choice (select multiple)</option>
        </select>

        <div id="option-container" style="{{ in_array(old('type'), ['Radio', 'Checkbox']) ? '' : 'display: none;' }}">
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
                @endif
            </div>
            @error('options')
            <p style="color:red">{{ $message }}</p>
            @enderror
        </div>

        <div id="followUpQuestions" style="{{ in_array(old('type'), ['RadioBool', 'RadioGrade']) ? '' : 'display: none;' }}">
            <div class="dataHeader">Add follow-up questions</div>
            <div id="followUpContainer">
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search...">
                <div id="searchResults">
                    @foreach($questions as $question)
                        <div class="following-question" id="{{ $question->id }}">
                            <div class="f-question-text">{{ $question->text }}</div>
                            <button class='fq-btn' type="button" onclick="addFollowUpQuestion('{{ $question->id }}')"></button>
                        </div>
                    @endforeach
                </div>
                <div id="selectedQuestions">

                </div>
            </div>
        </div>
        <form method="POST" action="{{route('questions.store')}}">
            @csrf
            <input type="hidden" id="hidden-text" name="text" value="{{ old('text') }}">
            <input type="hidden" id="hidden-type" name="type" value="{{ old('type') }}">
            <div id="hidden-options"></div>
            <div id="hidden-follow-ups"></div>

            <button id="action-btn" onclick="populateForm()">SAVE</button>
        </form>
    </section>

    <script src="{{ asset('js/questionEdit.js') }}"></script>
@endsection
