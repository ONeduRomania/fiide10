@extends('layouts.auth')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="mb-5 text-center">
        <h5 class="text-royal">
            <strong>FiiDe10</strong>.EduManager.{{ __('Confirmation') }}
        </h5>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="form-group">
            <label for="password" class="text-md-left">
                {{ __('Password') }}
                <a href="{{ route('password.request') }}" class="font-weight-lighter text-decoration-none">
                    <small>Forgot your password? Reset it.</small>
                </a>
            </label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block">
            {{ __('Confirm Password') }}
        </button>
    </form>
</div>
@endsection
