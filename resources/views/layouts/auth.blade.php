<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Primary Meta Tags --}}
    <title>Platforma Fii de 10!</title>
    <meta name="title" content="{{ config('app.name', 'Fii De 10!') }}">
    <meta name="description" content="Viitorul educației românești e în mâinile tale!">

    {{--  Open Grapgh / Facebook  --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL', 'localhost:8000') }}">
    <meta property="og:title" content="{{ config('app.name', 'Fii De 10!') }}">
    <meta property="og:description" content="Instrument de management al educației bazat pe module pentru a ajuta personalul școlii, profesorii și elevii.">
    <meta property="og:image" content="">

    {{--  Twitter  --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL', 'localhost:8000') }}">
    <meta property="twitter:title" content="{{ config('app.name', 'Fii De 10!') }}">
    <meta property="twitter:description" content="Instrument de management al educației bazat pe module pentru a ajuta personalul școlii, profesorii și elevii.">
    <meta property="twitter:image" content="">

    {{--  Scripts  --}}
    <script src="{{ mix('js/app.js') }}" defer></script>

    {{--  Styling  --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="row no-gutters">
            <div class="col-md-12 col-lg-7 login-section d-none d-lg-block">
                <div class="h-100 d-flex flex-column justify-content-between">
                    <div class="container my-4 d-flex flex-row justify-content-between">
                        <a class="text-decoration-none" href="{{ route('welcome') }}"><h4 class="text-white"><strong>Platforma Fii de 10</strong></h4></a>
                        @yield('link')
                    </div>
                    <div class="container my-4 text-center">
                        <small class="text-white-50">{{ __('Viitorul educației românești e în mâinile tale!') }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5 form-section">
                <x-navbar-component class="navbar navbar-expand-md fixed-top navbar-dark bg-royal d-lg-none" />
                <div class="h-100 d-flex align-items-center my-5">
                    @yield('content')
                </div>
            </div>
        </div>
        <x-footer-component/>
    </div>
</body>
</html>
