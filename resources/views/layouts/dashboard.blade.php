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
<div id="app">
    <x-navbar-component class="navbar navbar-expand-md navbar-dark bg-royal">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">{{ __('Panou de control') }}</a>
        </li>
        <li class="nav-item dropdown">
            <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false" v-pre>
                {{ __('Panou de control Admin') }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdown">
                @can('manage-users')
                    <a class="dropdown-item text-md-center" href="{{ route('users.index') }}">
                        {{ __('Administrează toți utilizatorii') }} <i class="fas fa-users-cog"></i>
                    </a>
                @endcan

                <a class="dropdown-item text-md-center" href="{{ route('schools.index') }}">
                    {{ __('Administrează toate școlile') }} <i class="fas fa-address-book"></i>
                </a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a id="schoolDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false" v-pre>
                {{ __('Panou de control Școală') }} <span class="caret"></span>
            </a>


            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="schoolDropdown">
                @can('manage-users')
                    <a class="dropdown-item text-md-center" href="{{ route('users.index') }}">
                        {{ __('Administrează toți utilizatorii') }} <i class="fas fa-users-cog"></i>
                    </a>
                @endcan

                <a class="dropdown-item text-md-center" href="{{ route('schools.index') }}">
                    {{ __('Administrează toate școlile') }} <i class="fas fa-address-book"></i>
                </a>
            </div>
        </li>
    </x-navbar-component>
    <x-breadcrumb-component/>

    @yield('content')
    <x-footer-component/>
</div>

@yield('scripts')
</body>
</html>
