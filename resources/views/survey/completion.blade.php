@extends('./layouts/surveylayout')

@section('pageCSS')
    <link rel="stylesheet" href="{{asset('css/completion.css')}}">
    <link rel="stylesheet" href="{{asset('css/home.css')}}" />
    <link rel="stylesheet" href="{{asset('css/survey.css')}}" />
    <link rel="stylesheet" href="{{asset('css/index.css')}}" />
@endsection

@section('content')
    <div class="thank-you-container">
        <h1 class="thank-you-text">Thank You!</h1>
        <p class="thank-you-message">We appreciate your submission.</p>
    </div>
@endsection
