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
    @yield('title')
</head>

<body>

 @include('/layouts/asideMenu')
<section class="content">
    <div style="width: 120%; background: #52688F; height: 20px">
        <div style="display: flex; justify-content: flex-end; background: #52688F; height: 20px; width: 100%;">
            <a style="margin-left: 85%; width: 100%; color: #FFFFFF" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Log out
            </a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    @yield('content')
</section>
</body>
</html>
