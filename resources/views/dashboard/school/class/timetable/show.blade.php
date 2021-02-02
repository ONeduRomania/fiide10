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
            <div class="container">
                <h5> Ziua: {{ $timetable->subjects->name }}</h5>
                <p class="text-muted">De aici poți edita ziua materiei.</p>

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <form method="POST" action="{{ route('timetable.update', ['school' => $school->id, 'class' => $class->id, 'timetable' => $timetable->id]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label for="subject" class="text-md-left">{{ __('Select subject') }}</label>
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
                                        <label for="date_start" class="text-md-left">Introdu ziua și ora la care începe ora:</label>

                                        <input id="date_start" type="datetime" class="form-control @error('date_start') is-invalid @enderror" name="date_start" value="{{ old('date_start') }}" placeholder="{{ __('Enter here the start date...') }}" required>
                                        @error('date_start')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="date_end" class="text-md-left">Introdu ziua și ora la care ia final ora:</label>

                                        <input id="date_end" type="datetime" class="form-control @error('date_end') is-invalid @enderror" name="date_end" value="{{ old('date_end') }}" placeholder="{{ __('Enter here the finish date...') }}" required>
                                        @error('date_end')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-gray">Editează</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

