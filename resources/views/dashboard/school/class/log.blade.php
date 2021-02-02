@extends('layouts.dashboard')

@section('content')
    <div class="section-info d-flex align-items-center my-5">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert" role="alert">
                    <button type="button" class="btn btn-royal dismissible" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="fas fa-times"></i>
                        </span>
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
                            <strong>Eroare:</strong> {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <h5>Adaugă o notă</h5>
                        <p class="text-muted">De aici poți adăuga note elevilor clasei tale. Sperăm că sunt note mari :)</p>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <div class="card shadow-lg">
                            <form method="POST" action="{{ route('classes.mark', ['school' => $school->id, 'class' => $class->id]) }}">
                                <div class="card-body">
                                    @csrf
                                    <div class="form-group">
                                        <label for="term" class="text-md-left">{{ __('Select the term') }}</label>

                                        <select id="term" name="term" class="form-control @error('term') is-invalid @enderror" required autofocus>
                                            <option value="1">{{ __('First term') }}</option>
                                            <option value="2">{{ __('Second term') }}</option>
                                        </select>
                                        @error('term')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="student" class="text-md-left">Selectează elevul</label>
                                        <select id="student" name="student" class="form-control @error('student') is-invalid @enderror" required autofocus>
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
                                        <label for="subject" class="text-md-left">Selectează materia</label>
                                        <select id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" required autofocus>
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
                                        <label for="mark" class="text-md-left">Introdu nota pe care o acorzi (de la 1 la 10)</label>

                                        <input id="mark" type="text" class="form-control @error('mark') is-invalid @enderror" name="mark" value="{{ old('mark') }}" placeholder="Introdu nota aici..." required autocomplete="mark" autofocus>
                                        @error('mark')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="date" class="text-md-left">Introdu data:</label>

                                        <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" placeholder="Introdu data aici..." required>
                                        @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                        <h5>Adaugă o absență</h5>
                        <p class="text-muted">De aici poți introduce absențele elevului.</p>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <div class="card shadow-lg">
                            <form method="POST" action="{{ route('classes.absence', ['school' => $school->id, 'class' => $class->id]) }}">
                                <div class="card-body">
                                    @csrf
                                    <div class="form-group">
                                        <label for="term" class="text-md-left">{{ __('Select the term') }}</label>

                                        <select id="term" name="term" class="form-control @error('term') is-invalid @enderror" required autofocus>
                                            <option value="1">{{ __('First term') }}</option>
                                            <option value="2">{{ __('Second term') }}</option>
                                        </select>
                                        @error('term')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="student" class="text-md-left">Selectează studentul:</label>
                                        <select id="student" name="student" class="form-control @error('student') is-invalid @enderror" required autofocus>
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
                                        <label for="subject" class="text-md-left">Selectează materia:</label>
                                        <select id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" required autofocus>
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
                                        <label for="date_absence" class="text-md-left">Introdu data</label>

                                        <input id="date_absence" type="date" class="form-control @error('date_absence') is-invalid @enderror" name="date_absence" value="{{ old('date_absence') }}" placeholder="Introdu data aici..." required>
                                        @error('date_absence')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-gray">Marchează absența</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
