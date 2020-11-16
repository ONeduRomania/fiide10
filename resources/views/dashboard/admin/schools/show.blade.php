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
                <h5>{{ __('Show school data') }}: {{ $school->name }}</h5>
                <p class="text-muted">{{ __('From here you can edit the school\'s data or see the school\'s data.') }}</p>

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card shadow-lg">
                            <form method="POST" action="{{ route('schools.update', $school->id) }}">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
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
                                    <button type="submit" class="btn btn-gray">{{ __('Edit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="card shadow-lg">
                            <div class="card-body d-flex justify-content-center">
                                <small class="text-muted">{{ __('If you want to edit more details about this school you can go right here: ') }}<a class="text-decoration-none text-primary" href="">Edit <i class="fas fa-edit"></i></a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
