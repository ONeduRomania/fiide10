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
                            <strong>Eroare: </strong> {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="container">
{{--                TODO: Adauga tema noua --}}
                <div class="row">
                    <div class="col-md-12 col-lg-12 text-center">
                        <h5>Adaugă o nouă temă</h5>
                        <p class="text-muted">De aici se pot adăuga teme noi pentru elevi.</p>
                        <button type="button" class="btn btn-block btn-royal" data-toggle="modal" data-target="#homeworkModal">Adaugă o nouă temă <i class="fas fa-swatchbook"></i></button>
                    </div>
                </div>

{{--                <hr class="my-3" />--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-12 col-lg-12 text-center">--}}
{{--                        <div id="timetable-component" data-timetable="{{ $timetables }}"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <hr class="my-3" />
                <div class="row">
                    <div class="col-md-12 col-lg-12 text-center">
                        <h5>Verifică temele</h5>
                        <p class="text-muted">De aici poți vedea temele create pentru această clasă până în prezent.</p>
                        <div class="card shadow-lg my-1">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    NUME DE TEMA
                                    <br />
                                    <small class="text-muted">Dată limită: <strong>22 MARTIE 2021</strong></small>
                                    <br />
                                    <small class="text-muted"><strong>0</strong> teme trimise</small>
                                </div>
                                <div>
                                    <form class="d-inline-flex mx-1">
{{--                                        @csrf--}}
{{--                                        @method('DELETE')--}}
                                        <button type="submit" class="btn btn-danger">Elimină</button>
                                    </form>

                                    <a class="text-royal text-decoration-none mx-1" href="#">Editează</a>
                                </div>
                            </div>
                        </div>
                        @foreach ($homeworks as $homework)
                            <div class="card shadow-lg my-1">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ $homework->name }}
                                        <br />
                                        <small class="text-muted">Due date: <strong>{{ $homework->due_date }}</strong></small>
                                    </div>
                                    <div>
                                        <form action="{{ route('timetable.delete', ['school' => $school->id, 'class' => $classroom->id, 'timetable' => $subject->id]) }}" method="POST" class="d-inline-flex mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Elimină</button>
                                        </form>

                                        <a class="text-royal text-decoration-none mx-1" href="{{ route('timetable.check', ['school' => $school->id, 'class' => $classroom->id, 'timetable' => $subject->id]) }}">Editează</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="homeworkModal" tabindex="-1" aria-labelledby="homeworkModalLink" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('timetable.create', ['school' => $school->id, 'class' => $classroom->id]) }}" method="POST">
{{--TODO: Form--}}
                    {{--                    @csrf--}}
{{--                    <div class="modal-header">--}}
{{--                        <h5 class="modal-title" id="exampleModalLabel">Adaugă o nouă materie în orar.</h5>--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                            <span aria-hidden="true">&times;</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="subject" class="text-md-left">Selectează materia</label>--}}
{{--                            <select id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" required autofocus>--}}
{{--                                @foreach($subjects as $subject)--}}
{{--                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('subject')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="date_start" class="text-md-left">Introdu ora la care începe ora:</label>--}}

{{--                            <input id="date_start" type="datetime" class="form-control @error('date_start') is-invalid @enderror" name="date_start" value="{{ old('date_start') }}" placeholder="{{ __('Enter here the start date...') }}" required>--}}
{{--                            @error('date_start')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="date_end" class="text-md-left">Introdu ora la care se finalizează ora:</label>--}}

{{--                            <input id="date_end" type="datetime" class="form-control @error('date_end') is-invalid @enderror" name="date_end" value="{{ old('date_end') }}" placeholder="Introdu aici ziua..." required>--}}
{{--                            @error('date_end')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="submit" class="btn btn-royal">Creează <i class="fas fa-check"></i></button>--}}
{{--                    </div>--}}
                </form>
            </div>
        </div>
    </div>
@endsection
