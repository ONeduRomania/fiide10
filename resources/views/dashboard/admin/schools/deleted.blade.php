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
                <h5>{{ __('Deleted schools') }}</h5>
                <p class="text-muted">{{ __('From here you can restore some schools or delete their accounts permanently, after 30 days their accounts are deleted forever.') }}</p>

                @foreach ($schools as $school)
                    <div class="card shadow-lg my-1">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                {{ $school->name }}
                                <br/>
                                <small class="text-muted">{{ $school->email_contact }}</small>
                            </div>
                            <div>
                                <form action="{{ route('schools.force', $school->id) }}" method="POST" class="d-inline-flex mx-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{ __('Recycle') }}</button>
                                </form>

                                <form action="{{ route('schools.restore', $school->id) }}" method="POST" class="d-inline-flex mx-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-link text-royal text-decoration-none">{{ __('Restore') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $schools->links() }}
            </div>
        </div>
    </div>
@endsection
