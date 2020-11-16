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
                    <h5>{{ __('Add a new user') }}</h5>
                    <p class="text-muted">{{ __('Here you can add a new user to the platform acording to your details.') }}</p>
                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="card shadow-lg">
                        <form method="POST" action="{{ route('users.store') }}">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="text-md-left">{{ __('Full name') }}</label>

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ __('Enter user\'s full name...') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email" class="text-md-left">{{ __('E-Mail Address') }}</label>

                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('Enter user\'s e-mail address...') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="role" class="text-md-left">{{ __('Select user\'s role') }}</label>
                                    <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" id="role" required autofocus>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password" class="text-md-left">
                                        {{ __('Password') }}
                                    </label>

                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Enter user\'s password...') }}" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="text-md-left">
                                        {{ __('Confirm your password') }}
                                    </label>

                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Enter user\'s password again...') }}" required autocomplete="new-password">
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
                    <h5>{{ __('Manage your users') }}</h5>
                    <p class="text-muted">{{ __('If you want to manage your users you can do it right here, change their roles, their permissions, etc...') }}</p>
                </div>

                <div class="col-md-12 col-lg-6">
                    <a href="{{ route('users.deleted') }}" class="btn btn-danger mb-1">
                        {{ __('Deleted users') }} <i class="fas fa-user-times"></i>
                    </a>
                    @foreach ($users as $user)
                        <div class="card shadow-lg my-1">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                        {{ $user->name }}
                                        <br/>
                                        <small class="text-muted">{{ $user->roles[0]->name }}</small>
                                </div>
                                <div>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-flex mx-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                    </form>

                                    <a class="text-royal text-decoration-none mx-1" href="{{ route('users.show', $user->id) }}">{{ __('Edit') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
