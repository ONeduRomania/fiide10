@extends('layouts.auth')

@section('link')
    <a class="btn btn-outline-white" href="{{ route('login') }}">{{ __('Take me to login page') }} <i class="fas fa-user"></i></a>
@endsection

@section('content')
    <div class="container-fluid px-5 py-5">
        @if (session('status'))
            <div class="alert" role="alert">
                <button type="button" class="btn btn-royal dismissible" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="fas fa-times"></i>
                    </span>
                </button>
                <p class="my-1">
                    {{ session('status') }}
                </p>
            </div>
        @endif

        <div class="mb-5 text-center">
            <h5 class="text-royal">
                <strong>FiiDe10</strong>.EduManager.{{ __('Password.Reset') }}
            </h5>
        </div>

        <form class="mb-1" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="text-md-left">{{ __('E-Mail Address') }}</label>

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-outline-royal btn-block">
                {{ __('Send Password Reset Link') }}
            </button>
        </form>
    </div>
@endsection
