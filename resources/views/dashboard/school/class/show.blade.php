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
                            <strong>Eroare:</strong> {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif
            <div class="container">
                <h5>Clasa: {{ $class->name }}</h5>

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card shadow-lg">
                            <form method="POST" action="{{ route('classes.update', ['school' => $school->id, 'class' => $class->id]) }}">
                                <div class="card-body">
                                    @method('PATCH')
                                    @csrf
                                    <div class="form-group">
                                        <label for="name" class="text-md-left">Clasa: </label>

                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Introdu numărul și litera clasei..." required autocomplete="name" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="master_teacher" class="text-md-left">Selectează dirigintele:</label>

                                        <select id="master_teacher" name="master_teacher" class="form-control @error('master_teacher') is-invalid @enderror" required autofocus>
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
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-gray">Editează</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="card shadow-lg">
                            <div class="card-body d-flex justify-content-center">
                                <small class="text-muted">Dacă vrei să editezi orarul profesorului, o poți face de aici: <a class="text-decoration-none text-primary" href="{{ route('timetable.show', ['school' => $school->id, 'class' => $class->id]) }}">Editează<i class="fas fa-edit"></i></a></small>
                            </div>
                        </div>

                        <div class="my-3 card shadow-lg">
                            <div class="card-body d-flex justify-content-center">
                                <small class="text-muted">{{ __('If you want to go to insert a new log go: ') }}<a class="text-decoration-none text-primary" href="{{ route('classes.log', ['school' => $school->id, 'class' => $class->id]) }}">click aici <i class="fas fa-link"></i></a></small>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-3" />

                <div class="row">
                    <div class="col-md-12 col-lg-12 text-center">
                        <h5>Invită un elev să se alăture!</h5>
                        <p class="text-muted">Aici poți invita elevii să se alăture clasei.</p>
                        <button type="button" class="btn btn-block btn-royal" data-toggle="modal" data-target="#linkModal">Obține un link de invitație <i class="fas fa-link"></i></button>
                    </div>
                </div>

                <hr class="my-3" />
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <h5>Sunt elevi la tine în clasă?</h5>
                        <p class="text-muted">Aici elevii așteaptă aprobarea ta.</p>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        @foreach ($requests as $request)
                            <div class="card shadow-lg my-1">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>{{ $request->user->name }}</div>
                                    <div>
                                        <form action="{{ route('classes.removerequest', ['school' => $school->id, 'class' => $class->id, 'request' => $request->id]) }}" method="POST" class="d-inline-flex mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Nu este la mine în clasă</button>
                                        </form>

                                        <form action="{{ route('classes.acceptrequest', ['school' => $school->id, 'class' => $class->id, 'request' => $request->id]) }}" method="POST" class="d-inline-flex mx-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success">Permite</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{ $requests->links() }}
                    </div>
                </div>

                <hr class="my-3" />
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <h5>Gestionează elevii</h5>
                        <p class="text-muted">De aici poți gestiona elevii clasei tale.</p>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        @foreach ($students as $student)
                            <div class="card shadow-lg my-1">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>{{ $student->user->name }}</div>
                                    <div>
                                        <form action="{{ route('classes.student.destroy', ['school' => $school->id, 'class' => $class->id, 'student' => $student->id]) }}" method="POST" class="d-inline-flex mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Elimină elevul</button>
                                        </form>

                                        <a class="text-royal text-decoration-none mx-1" href="{{ route('classes.student.show', ['school' => $school->id, 'class' => $class->id, 'student' => $student->id]) }}">Editează</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{ $students->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="linkModal" tabindex="-1" aria-labelledby="linkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Obține un link de invitație</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input id="link" type="text" value="{{ route('invite.link', $invite->code) }}" readonly class="form-control" placeholder="Copy invite link" aria-label="Copiază linkul invitației" aria-describedby="button-link">
                            <button class="btn btn-royal" type="button" id="button-link" data-clipboard-target="#link">Copiază</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('classes.renew', ['school' => $school->id, 'class' => $class->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-royal">Generează alt link<i class="fas fa-link"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
