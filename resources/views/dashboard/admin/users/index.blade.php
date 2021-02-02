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
                            <strong>Eroare: </strong> {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <h5>Adaugă un utilizator nou</h5>
                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="card shadow-lg">
                        <form method="POST" action="{{ route('users.store') }}">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="text-md-left">Numele elevului:</label>

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email" class="text-md-left">Adresa de e-mail:</label>

                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="role" class="text-md-left">Selectează rolul:</label>}</label>
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
                                        Parola:
                                    </label>

                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="text-md-left">
                                        Confirmă parola:
                                    </label>

                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-gray">Adaugă</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr class="my-3" />
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <h5>Gestionează utilizatorii</h5>
                    <p class="text-muted">Poți modifica detalii, roluri, etc.</p>
                </div>

                <div class="col-md-12 col-lg-6">
                    <a href="{{ route('users.deleted') }}" class="btn btn-danger mb-1">
                        Utilizatori eliminați <i class="fas fa-user-times"></i>
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
                                        <button type="submit" class="btn btn-danger">Șterge</button>
                                    </form>

                                    <a class="text-royal text-decoration-none mx-1" href="{{ route('users.show', $user->id) }}">Editează</a>
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
