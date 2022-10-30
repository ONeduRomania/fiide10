@extends('dashboard.admin.schools.show')

@section('pageName')
    {{$subject->name}}
@endsection

@section('subcontent')
    <div class="container-fluid">
        <div class="col">
            <form method="POST" action="{{ route('subjects.update', ['school' => $school->id, 'subject' => $subject->id]) }}">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="name" class="text-md-left">Numele materiei:</label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name', $subject->name) }}" required autocomplete="name" autofocus>
                    @error('name')
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
