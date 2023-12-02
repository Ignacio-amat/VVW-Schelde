@extends('./layouts/layouts')

@section('pageCSS')
    <link rel="stylesheet" href="css/home.css"/>
@endsection

@section('title')
    <title>Home</title>
@endsection
@section('content')
    <div class="mainPlaceHolder">
      <h1 class="header">Welcome {{ Auth::user()->name }}</h1>
        <div class="contentPlaceHolder">
            <div class="graph">
                <h3 class="graphHeader">Average rating of all categories</h3>
                <div class="graphPlaceHolder">
                        <p id="errorMessage">There are no categories to be displayed or <br>every category has only text answers</p>
                    <canvas id="graph">
                    </canvas>
                    <div id="selection" class="dropdown">
                        <button class="dropbtn">
                            Choose Graph Type
                        </button>

                        <div class="dropdown-content">
                            <a onclick="lineChartSelected()" href="#"><img src="/assets/icons/general/line-graph.png" width="20" height="15"> Line</a>

                            <a onclick="barChartSelected()" href="#"><img src="/assets/icons/general/bar-chart.png" width="20" height="15"> Bar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widgets">
                <div class="widget">
                    <div class="weather">
                        <p id="location" class="location">Vlissingen</p>
                        <img id="weatherImg" class="weatherImg"/>
                        <div class="weatherData">
                            <p id="temperature" class="temperature"></p>
                            <div class="compass">
                                <div class="direction">
                                    <p id="windSpeed" class="windSpeed"></p>
                                </div>
                                <div id="windDireciton" class="arrow"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div id="dateTime" class="dateTime">
                        <p id="data" class="field date"></p>
                        <p id="time" class="field time"></p>
                        <div class="animationContainer">
                            <script
                                src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                            <lottie-player class="animation"
                                           src="https://assets9.lottiefiles.com/datafiles/N8DaINa2dmLOJja/data.json"
                                           background="transparent" mode="bounce" speed="2" loop
                                           autoplay></lottie-player>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <h4 class="widgetHeader">Latest survey answers</h4>
                    <div>
                        @foreach($latest_answers as $latest_answer)
                            <p class="latestAnswer">{{$latest_answer}}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="overallSatisfaction">
            <h2 style="text-align: center; ">Overall Satisfaction is <span class="progress-text"></span></h2>
            <div style="display: inline-block">
                <img src="{{ asset('assets/icons/general/sad.png') }}" style="height: 45px; margin-right: -50px; vertical-align: middle; margin-top: -60px">
                <div id='prog-bar-cont' style="display: inline-block;">
                    <div id="prog-bar">
                        <div id="background"></div>
                    </div>
                </div>
                <img src="{{ asset('assets/icons/general/happy.png') }}" style="height: 45px; margin-left: 70px; vertical-align: middle; margin-top: -60px">
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/homeScreenChart.js"></script>
    <script src="js/weather.js"></script>
@endsection
