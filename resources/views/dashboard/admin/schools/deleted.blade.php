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
                            <strong>Eroare:</strong> {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif
            <div class="container">
                <h5>Școli eliminate:</h5>
                <p class="text-muted">Poți să restaurezi școala sau să o ștergi definitiv. Nu uita, ai doar 30 de zile să te răzgândești.</p>

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
                                    <button type="submit" class="btn btn-danger">Șterge definitiv</button>
                                </form>

                                <form action="{{ route('schools.restore', $school->id) }}" method="POST" class="d-inline-flex mx-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-link text-royal text-decoration-none">Restaurează</button>
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
