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
                  Un mail a fost trimis la tine pentru a-ți valida contul. Nu uita să verifici și folderul Spam.
                </p>
            </div>
        @endif

        <div class="mb-5 text-center">
            <h5 class="text-royal">
                <strong>Platforma Fii de 10</strong>
            </h5>
        </div>

        <div class="card text-white bg-royal mb-3">
            <div class="card-header">Validează-ți contul!</div>

            <div class="card-body text-center">
               Înainte de a-ți accesa contul, confirmă adresa de e-mail.
                <form class="mt-2" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-white"> Cere un alt mail...</button>
                </form>
            </div>
        </div>
    </div>
@endsection
