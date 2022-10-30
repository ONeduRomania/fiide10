@extends('dashboard.admin.schools.show')

@section('pageName')
    {{__('Adaugă o materie nouă')}}
@endsection

@section('subcontent')
    <div class="container-fluid">
        <div class="col">
            <form method="POST" action="{{ route('subjects.store', $school->id) }}">
                @csrf
                <div class="form-group">
                    <label for="name" class="text-md-left">Numele materiei:</label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
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
