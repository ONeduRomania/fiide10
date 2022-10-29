@extends('layouts.dashboard')

@section('pageName')
    {{__('Editează școala')}}
@endsection

@section('content')
    <div class="container-fluid">
        <x-alert/>

        <div class="col">
            <form method="POST" action="{{ route('schools.update', $school->id) }}">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="name" class="text-md-left">Numele unității de învățământ:</label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name', $school->name) }}" required autocomplete="name" autofocus>
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
                           value="{{ old('email_contact', $school->email_contact) }}" required
                           autocomplete="email_contact" autofocus>
                    @error('email_contact')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address" class="text-md-left">Adresa: </label>

                    <input id="address" type="text"
                           class="form-control @error('address') is-invalid @enderror" name="address"
                           value="{{ old('address', $school->address) }}" autocomplete="address"
                           autofocus>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone_number" class="text-md-left">Numărul de telefon:</label>

                    <input id="phone_number" type="text"
                           class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                           value="{{ old('phone_number', $school->phone_number) }}" autocomplete="phone_number"
                           autofocus>
                    @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Salvează</button>
            </form>
        </div>
    </div>
@endsection
