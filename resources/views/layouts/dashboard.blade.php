<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Primary Meta Tags --}}
    <title>{{ config('app.name', 'Platforma Fii de 10!') }}</title>
    <meta name="title" content="{{ config('app.name', 'Platforma Fii de 10!') }}">
    <meta name="description" content="Digitalizăm Educație Împreună!">

    {{--  Open Grapgh / Facebook  --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL', 'localhost:8000') }}">
    <meta property="og:title" content="{{ config('app.name', 'Fii De 10!') }}">
    <meta property="og:description"
          content="Instrument de management al educației bazat pe module pentru a ajuta personalul școlii, profesorii și elevii.">
    <meta property="og:image" content="">

    {{--  Twitter  --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL', 'localhost:8000') }}">
    <meta property="twitter:title" content="{{ config('app.name', 'Fii De 10!') }}">
    <meta property="twitter:description"
          content="Instrument de management al educației bazat pe module pentru a ajuta personalul școlii, profesorii și elevii.">
    <meta property="twitter:image" content="">

    {{--  Scripts  --}}
    <script src="{{ mix('js/app.js') }}" defer></script>

    {{--  Styling  --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
          rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="container-fluid">
    <div class="row">
        <x-navbar-component class="col-sm-12 col-md-3 nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">{{ __('Noutăți') }}</a>
            </li>
            @role('admin')
                <x-navbar.admin />
            @endrole
            @role('student')
                <x-navbar.student />
            @endrole
            @role('teacher')
            <x-navbar.teacher />
            @endrole
        </x-navbar-component>
        <div class="col">
            <x-breadcrumb-component/>

            @yield('content')
            <x-footer-component/>
        </div>
    </div>
</div>

@yield('scripts')
</body>
</html>
