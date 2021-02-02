<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Primary Meta Tags --}}
    <title>Platforma Fii de 10!</title>
    <meta name="title" content="Platforma Fii de 10!">
    <meta name="description" content="Digitalizăm Educație Împreună!">

    {{--  Open Grapgh / Facebook  --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL', 'localhost:8000') }}">
    <meta property="og:title" content="{{ config('app.name', 'FiiDe10.EduManager') }}">
    <meta property="og:description" content="Education management tool based on modules to help school staff, teachers and students.">
    <meta property="og:image" content="">

    {{--  Twitter  --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL', 'localhost:8000') }}">
    <meta property="twitter:title" content="{{ config('app.name', 'FiiDe10.EduManager') }}">
    <meta property="twitter:description" content="Education management tool based on modules to help school staff, teachers and students.">
    <meta property="twitter:image" content="">

    {{--  Scripts  --}}
    <script src="{{ mix('js/app.js') }}" defer></script>
    @stack('scripts')

    {{--  Styling  --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
</body>
</html>

