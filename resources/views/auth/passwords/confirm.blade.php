@extends('layouts.auth')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="mb-5 text-center">
        <h5 class="text-royal">
            <strong>Platforma Fii de 10!</strong>
        </h5>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="form-group">
            <label for="password" class="text-md-left">
                Parola
                <a href="{{ route('password.request') }}" class="font-weight-lighter text-decoration-none">
                    <small>Ai uitat parola? Reseteaz-o.</small>
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
           Confirmă parola
        </button>
    </form>
</div>
@endsection
