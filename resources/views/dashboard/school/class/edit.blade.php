@extends('dashboard.admin.schools.show')

@section('pageName')
    {{__('Editează clasa')}} - {{$class->name}}
@endsection

@section('content')
    <div class="container-fluid">
        <x-alert/>

        <div class="col">
            <form method="POST" action="{{ route('classes.update', ['school' => $school->id, 'class' => $class->id]) }}">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="name" class="text-md-left">Numărul și litera clasei:</label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name', $class->name) }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="master_teacher" class="text-md-left">Selectează dirigintele clasei:</label>
                    <select id="master_teacher" name="master_teacher"
                            class="form-control @error('master_teacher') is-invalid @enderror" required autofocus>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->user->id }}">{{ $teacher->user->name }}</option>
                        @endforeach
                    </select>
                    @error('master_teacher')
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
