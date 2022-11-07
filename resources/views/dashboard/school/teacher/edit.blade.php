@extends('dashboard.admin.schools.show')

@section('pageName')
    {{ $teacher->user->name }}
@endsection

@section('subcontent')
    <div class="container-fluid">
        <x-alert/>

        <div class="col">
            <form method="POST" action="{{ route('teachers.update', ['school' => $school->id, 'teacher' => $teacher->id]) }}">
                @csrf
                @method('patch')

                <div class="form-group @error('subjects') is-invalid @enderror">
                    <label class="text-md-left">Selectează materiile predate:</label>
                    @foreach($subjects as $subject)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[{{$subject->id}}]" @checked(old("subjects[$subject->id]", $subject->thisTeacher)) id="subject-{{$subject->id}}-check">
                            <label class="form-check-label" for="subject-{{$subject->id}}-check">{{$subject->name}}</label>
                        </div>
                    @endforeach
                    @error('subjects')
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
