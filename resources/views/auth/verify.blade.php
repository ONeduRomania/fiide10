@extends('layouts.auth')

@section('content')
    <div class="container-fluid px-5 py-5">
        @if (session('resent'))
            <div class="alert" role="alert">
                <button type="button" class="btn btn-royal dismissible" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="fas fa-times"></i>
                    </span>
                </button>
                <p class="my-1">
                    {{ __('A fresh e-mail with the verification link was sent. Check your SPAM if you can\'t find it.')}}
                </p>
            </div>
        @endif

        <div class="mb-5 text-center">
            <h5 class="text-royal">
                <strong>FiiDe10</strong>.EduManager.{{ __('Email.Verify') }}
            </h5>
        </div>

        <div class="card text-white bg-royal mb-3">
            <div class="card-header">{{ __('Verify Your Email Address') }}</div>

            <div class="card-body text-center">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                <form class="mt-2" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-white">{{ __('Click here to request another verification link') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
