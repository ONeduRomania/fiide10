@extends('dashboard.admin.schools.show')

@section('pageName')
    {{$class->name}} - {{__('Catalog')}}
@endsection

@section('subcontent')
    <div class="container-fluid">
        <div class="col">
            <form method="POST" action="{{ route('log.store', ['school' => $school->id, 'class' => $class->id]) }}">
                @csrf
                <div class="form-group">
                    <label for="student" class="text-md-left">Elev:</label>
                    <select id="student" name="student"
                            class="form-control @error('student') is-invalid @enderror" required autofocus>
                        @foreach($students as $student)
                            <option value="{{ $student->user->id }}">{{ $student->user->name }}</option>
                        @endforeach
                    </select>
                    @error('student')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="subject" class="text-md-left">Materie:</label>
                    <select id="subject" name="subject"
                            class="form-control @error('subject') is-invalid @enderror" required autofocus>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="markSwitch">Selectează dacă pui o notă sau o absență:</label>
                    <select id="markSwitch" name="markSwitch" class="custom-select" onchange="showMarkField()">
                        <option selected value="mark">Notă</option>
                        <option value="absence">Absență</option>
                    </select>
                </div>

                <div id="markParent">
                    <div class="form-group" id="markGroup">
                        <label for="mark" class="text-md-left">Introdu nota pe care o acorzi (de la 1 la 10):</label>

                        <input id="mark" type="text" class="form-control @error('mark') is-invalid @enderror" name="mark"
                               value="{{ old('mark') }}" required autofocus>
                        @error('mark')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="date" class="text-md-left">Introdu data:</label>

                    <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date"
                           value="{{ old('date') }}" placeholder="Introdu data aici..." required>
                    @error('date')
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
@section('scripts')
    <script>
        // Hide the "Notă" field if "Absență" is selected.
        let oldGroupReference = null;
        function showMarkField() {
            const selectRef = document.querySelector('#markSwitch');
            if (selectRef.value === "absence") {
                const groupRef = document.querySelector('#markGroup');
                oldGroupReference = groupRef.cloneNode(true);
                groupRef.remove();
            } else if (oldGroupReference !== null) {
                document.querySelector('#markParent').appendChild(oldGroupReference);
            }
        }
        window.onload = showMarkField;
    </script>
@endsection
