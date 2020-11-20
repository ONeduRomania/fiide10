@extends('layouts.dashboard')

@section('content')
    <div class="section-info d-flex align-items-center my-5">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert" role="alert">
                    <button type="button" class="btn btn-royal dismissible" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                    <div class="my-1 text-center">
                        <p class="text-white">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert" role="alert">
                    <button type="button" class="btn btn-danger dismissible" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                    <div class="my-1 text-center">
                        <p class="text-white">
                            <strong>{{ __('Error: ') }}</strong> {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif


            <div class="container">
                <h5>{{ __('Show student data') }}: {{ $student->user->name }}</h5>
                <p class="text-muted">{{ __('From here you can delete / see the logs.') }}</p>
                <div id="catalog-component"
                     data-logs="{{ $logs }}"
                     data-class="{{ $class->id }}"
                     data-school="{{ $school->id }}"
                     data-name="{{ $student->user->name }}"
                     data-subjects="{{ $subjects }}"
                ></div>
            </div>
        </div>
    </div>
@endsection
