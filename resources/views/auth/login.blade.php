@extends('layouts.auth')

@section('link')
    <a class="btn btn-outline-white" href="{{ route('register') }}">{{ __('You don\'t have an account? Register here!') }} <i class="fas fa-user-plus"></i></a>
@endsection

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="mb-5 text-center">
        <h5 class="text-royal">
            <strong>FiiDe10</strong>.EduManager.{{ __('Login') }}
        </h5>
    </div>

    <form class="mb-1" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="text-md-left">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('Enter your e-mail address...') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="text-md-left">
                {{ __('Password') }}
                <a href="{{ route('password.request') }}" class="font-weight-lighter text-decoration-none">
                    <small>Forgot your password? Reset it.</small>
                </a>
            </label>

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Enter your password...') }}" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label">
                    {{ __('Remember my credentials') }}
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-royal btn-block">
            {{ __('Submit') }}
        </button>
    </form>

    <hr />

    <div class="row">
        <div class="col-md-12 col-lg-6 mt-1">
            <a class="btn btn-royal btn-block">
                {{ __('Login with your Facebook account') }}
                <i class="fab fa-facebook-f"></i>
            </a>
        </div>
        <div class="col-md-12 col-lg-6 mt-1">
            <a class="btn btn-royal btn-block">
                {{ __('Login with your Google account') }}
                <i class="fab fa-google"></i>
            </a>
        </div>
    </div>
</div>
@endsection
