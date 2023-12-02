@php use Illuminate\Http\Request; @endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="stylesheet" href="{{asset('css/layout.css')}}" />
    <link rel="stylesheet" href="{{asset('css/surveyAsideMenu.css')}}" />
    @yield('pageCSS')
    @yield('title')
</head>
<body>
<section class="asideMenuSection">
    <aside id="asideMenu" class="asideMenu">

    </aside>

</section>

<section class="content">
    @yield('content')
</section>
</body>
</html>
