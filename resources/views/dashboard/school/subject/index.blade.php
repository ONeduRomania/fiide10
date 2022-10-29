@extends('dashboard.admin.schools.show')

@section('subcontent')
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

            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <h5>{{ __('Add a new subject') }}</h5>
                    <p class="text-muted">{{ __('Here you can add a new subject to the platform acording to your details.') }}</p>
                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="card shadow-lg">
                        <form method="POST" action="{{ route('subjects.submit', $school_id) }}">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="text-md-left">{{ __('Name of the subject') }}</label>

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ __('Enter subject\'s name...') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-gray">{{ __('Add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr class="my-3" />
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <h5>{{ __('Manage your subjects') }}</h5>
                    <p class="text-muted">{{ __('If you want to manage your subjects you can do it right here, change their options, their master teachers, etc...') }}</p>
                </div>

                <div class="col-md-12 col-lg-6">
                    @foreach ($subjects as $subject)
                        <div class="card shadow-lg my-1">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>{{ $subject->name }}</div>
                                <div>
                                    <form action="{{ route('subjects.destroy', ['school' => $school_id, 'subject' => $subject->id]) }}" method="POST" class="d-inline-flex mx-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                    </form>

                                    <a class="text-royal text-decoration-none mx-1" href="{{ route('subjects.show', ['school' => $school_id, 'subject' => $subject->id]) }}">{{ __('Edit') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $subjects->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
