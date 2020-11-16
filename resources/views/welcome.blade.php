@extends('layouts.app')

@once
    @push('scripts')
        <script src="{{ mix('js/helpers.js') }}" defer></script>
    @endpush
@endonce

@section('content')
    <x-navbar-component class="navbar navbar-expand-md fixed-top navbar-dark bg-transparent">
        <li class="nav-item">
            <a class="nav-link" href="#feature">{{ __('Features') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#usage">{{ __('Correct usage') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#about">{{ __('About us') }}</a>
        </li>
    </x-navbar-component>

    <section class="section-main d-flex align-items-center">
        <div class="container text-center">
            <p class="text-white">
                <span class="badge badge-pill badge-royal">{{ __('New') }}</span>
                <small class="text-white-50">{{ __('Happy to manage all the stuff! New modules available.') }}</small>
            </p>
            <h3 class="text-white"><strong>FiiDe10</strong>.EduManager</h3>
            <h6 class="text-white">{{ __('Education management tool based on modules to help school staff, teachers and students.') }}</h6>
            <a class="mt-2 btn btn-royal @auth d-none @endauth" href="{{ route('register') }}">Create your account now</a>
        </div>
    </section>

    <div data-spy="scroll" data-target="#navbarMain" data-offset="0">
        <section class="section-info d-flex align-items-center" id="feature">
            <div class="container my-5">
                <h2 class="text-center mb-3 font-weight-bold">{{ __('What are our features?') }}</h2>

                <div class="row justify-content-center text-center my-5">
                    <div class="col-md-12 col-lg-4 my-3">
                        <img src="{{ asset('images/chart.svg') }}" height="100" />
                        <h5 class="font-weight-bold mt-1">{{ __('Metrics & Data') }}</h5>
                        <small class="text-muted">
                            {{ __('With our modules you can easily manage your school as a school manager and your school staff (teacher, aux. staff) and also the classrooms.') }}
                        </small>
                    </div>
                    <div class="col-md-12 col-lg-4 my-3">
                        <img src="{{ asset('images/files.svg') }}" height="100" />
                        <h5 class="font-weight-bold mt-1">{{ __('Assets') }}</h5>
                        <small class="text-muted">
                            {{ __('In your dashboard as a student / teacher you can manage your files which can be your homework or a course advisor.') }}
                        </small>
                    </div>
                    <div class="col-md-12 col-lg-4 my-3">
                        <img src="{{ asset('images/tasks.svg') }}" height="100" />
                        <h5 class="font-weight-bold mt-1">{{ __('Tasks') }}</h5>
                        <small class="text-muted">
                            {{ __('We want to provide an unique user experience, so for that in your dashboard you will find all the data about you as a student and also your tasks.') }}
                        </small>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-usage d-flex align-items-center text-center" id="usage">
            <div class="container section-text my-5 w-50">
                <h3 class="text-white font-weight-bold mb-3">{{ __('How to use our platform?') }}</h3>
                <p class="text-white-50">
                    {{ __('To use our platform, please register a new account and we will send you an e-mail, you will need to confirm that. After that you will be up and running in no time. We belive that the user interface is a clear guide for you on how to use the platform.') }}
                </p>
            </div>
        </section>

        <section class="section-about d-flex align-items-center" id="about">
            <div class="container section-text my-5 w-50">
                <h3 class="font-weight-bold mb-3 text-center">{{ __('About our team') }}</h3>
                <div class="row">
                    <div class="col-md-12 col-lg-6 text-center">
                        <h5 class="font-weight-bold">{{ __('Story of the application...') }}</h5>
                        <p class="text-muted">
                            {{ __('The application was started by Comunitatea ONedu Romania in the summer of 2020, the scope of this platform is to help schools and its staff & students to have a nice centralized platform.') }}
                        </p>
                    </div>
                    <div class="col-md-12 col-lg-6 text-center">
                        <img src="{{ asset('images/programming.svg') }}" height="100" />
                    </div>
                </div>
            </div>
        </section>
    </div>

    <x-footer-component/>
@endsection
