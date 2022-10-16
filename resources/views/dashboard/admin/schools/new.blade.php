@extends('layouts.dashboard')

@section('pageName')
    {{__('Adaugă o școală nouă')}}
@endsection

@section('content')
    <div class="container-fluid">
        <x-alert/>

        <div class="col">
            <form method="POST" action="{{ route('schools.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name" class="text-md-left">Numele unității de învățământ:</label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email_contact" class="text-md-left">Adresa de email:</label>

                    <input id="email_contact" type="email"
                           class="form-control @error('email_contact') is-invalid @enderror" name="email_contact"
                           value="{{ old('email_contact') }}" required autocomplete="email_contact" autofocus>
                    @error('email_contact')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address_type" class="text-md-left">Adresa: </label>

                    <input id="address_type" type="text"
                           class="form-control @error('address_type') is-invalid @enderror" name="address_type"
                           value="{{ old('address_type') }}" autocomplete="address_type" autofocus>
                    @error('address_type')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone_number" class="text-md-left">Numărul de telefon:</label>

                    <input id="phone_number" type="text"
                           class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                           value="{{ old('phone_number') }}" autocomplete="phone_number" autofocus>
                    @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Adaugă</button>
            </form>
        </div>
    </div>
@endsection
