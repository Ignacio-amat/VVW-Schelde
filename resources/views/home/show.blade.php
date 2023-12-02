@extends('./layouts/layouts')

@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('./css/category-show.css') }}"/>
@endsection

@section('title')
    <title>Home</title>
@endsection
@section('content')
    <h1 class="pageHeader">{{$categoryName}}</h1>
    <p id="errorMessages" class="errorMessages"></p>
    <div class="graphSection">
        <div class="questions">
            <div class="questionBlock overview" id="overview" onclick="onOverviewClick()">
                <p class="questionText overviewText">Overview</p>
            </div>
            <div class="scrollingSection" id="scrollingSection">
                @foreach($questions as $question)
                    <div class="questionBlock">
                        <p class="questionText">{{$question->text}}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="graphAndSoringOptions">
            <div class="graphDiv" id="graphDiv">
                <canvas id="graph" class="graph">

                </canvas>
                <div id="selection" class="dropdown">
                    <button class="dropbtn">
                        Choose Graph Type
                    </button>

                    <div class="dropdown-content">
                        <a onclick="lineChartSelected()" href="#"><img
                                src="{{ asset('assets/icons/general/line-graph.png') }}" alt="Line Graph"
                                width="20" height="15"> Line</a>

                        <a onclick="barChartSelected()" href="#"><img
                                src="{{ asset('assets/icons/general/bar-chart.png') }}" alt="Bar Chart"
                                width="20" height="15"> Bar</a>
                    </div>
                </div>
            </div>
            <div class="soring-options">
                <div id="years" class="years">

                </div>
                <div id="months" class="months">

                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/Question-show/chartObjects.js') }}"></script>
    <script src="{{ asset('js/Question-show/overview.js') }}"></script>
    <script src="{{ asset('js/Question-show/yearAndMonthsLoading.js') }}"></script>
    <script src="{{ asset('js/Question-show/question-show.js') }}"></script>
    <script src="{{ asset('js/Question-show/sorting.js') }}"></script>
@endsection
