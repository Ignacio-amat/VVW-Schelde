@php use Illuminate\Http\Request; @endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    @yield('pageCSS')
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="{{ asset('./css/layout.css') }}"/>
    <link rel="stylesheet" href="{{ asset('./css/login.css') }}"/>
    @yield('title')
</head>

<body style="background-image: url('{{ asset('assets/icons/general/boat-on-sea.jpeg') }}'); background-size: cover; background-position: center">
<section class="content rectangle">
    <div style="width: 100%; height: 20px; box-sizing: border-box">
        <div class="navbar-left">
            @if (Route::currentRouteName() === 'login')
                <a class="navbar-link" style="color: #ffffff" href="{{ route('register') }}">Go to Register Page</a>
                <span class="link-separator">|</span>
            @elseif (Route::currentRouteName() === 'register')
                <a class="navbar-link" style="color: #ffffff" href="{{ route('login') }}">Go to Login Page</a>
                <span class="link-separator">|</span>
            @endif
            <a class="navbar-link" style="color: #ffffff" href="{{ route('survey.index') }}">Click here to go back to the survey</a>
        </div>
    </div>
    @yield('content')
</section>
</body>
</html>
