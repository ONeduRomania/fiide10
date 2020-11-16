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

            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <h5>{{ __('Add a new school') }}</h5>
                    <p class="text-muted">{{ __('Here you can add a new school to the platform acording to your details.') }}</p>
                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="card shadow-lg">
                        <form method="POST" action="{{ route('schools.store') }}">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="text-md-left">{{ __('Name of the institution') }}</label>

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ __('Enter institution\'s full name...') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email_contact" class="text-md-left">{{ __('E-Mail Address') }}</label>

                                    <input id="email_contact" type="email" class="form-control @error('email_contact') is-invalid @enderror" name="email_contact" value="{{ old('email_contact') }}" placeholder="{{ __('Enter institution\'s e-mail address...') }}" required autocomplete="email_contact" autofocus>
                                    @error('email_contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="address_type" class="text-md-left">{{ __('Address') }}</label>

                                    <input id="address_type" type="text" class="form-control @error('address_type') is-invalid @enderror" name="address_type" value="{{ old('address_type') }}" placeholder="{{ __('Enter institution\'s address...') }}" autocomplete="address_type" autofocus>
                                    @error('address_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone_number" class="text-md-left">{{ __('Phone number') }}</label>

                                    <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" placeholder="{{ __('Enter institution\'s phone number...') }}" autocomplete="phone_number" autofocus>
                                    @error('phone_number')
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
                    <h5>{{ __('Manage your schools') }}</h5>
                    <p class="text-muted">{{ __('If you want to manage your schools you can do it right here, change their options, their directors, etc...') }}</p>
                </div>

                <div class="col-md-12 col-lg-6">
                    <a href="{{ route('schools.deleted') }}" class="btn btn-danger mb-1">
                        {{ __('Deleted schools') }} <i class="fas fa-user-times"></i>
                    </a>
                    @foreach ($schools as $school)
                        <div class="card shadow-lg my-1">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                        {{ $school->name }}
                                        <br/>
                                        <small class="text-muted">{{ $school->email_contact }}</small>
                                </div>
                                <div>
                                    <form action="{{ route('schools.destroy', $school->id) }}" method="POST" class="d-inline-flex mx-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                    </form>

                                    <a class="text-royal text-decoration-none mx-1" href="{{ route('schools.show', $school->id) }}">{{ __('Edit') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $schools->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
