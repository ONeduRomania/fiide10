@extends('dashboard.admin.schools.show')

@section('subcontent')
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

            <div class="row">
                <div class="col-md-12 col-lg-12 text-center">
                    <h5>Invită un profesor nou:</h5>
                    <p class="text-muted">De aici poți invita profesorii să se alăture.</p>
                    <button type="button" class="btn btn-block btn-royal" data-toggle="modal" data-target="#linkModal">Obține un link de invitație <i class="fas fa-link"></i></button>
                </div>
            </div>

            <hr class="my-3" />
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <h5>Sunt profesori în școală?</h5>
                    <p class="text-muted">Aici poți vedea ce profesori așteaptă aprobarea ta pentru a intra în școala virtuală.</p>
                </div>

                <div class="col-md-12 col-lg-6">
                    @foreach ($requests as $request)
                        <div class="card shadow-lg my-1">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>{{ $request->user->name }}</div>
                                <div>
                                    <form action="{{ route('teachers.removerequest', ['school' => $school->id, 'request' => $request->id]) }}" method="POST" class="d-inline-flex mx-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Nu îl recunosc.</button>
                                    </form>

                                    <form action="{{ route('teachers.acceptrequest', ['school' => $school->id, 'request' => $request->id]) }}" method="POST" class="d-inline-flex mx-1">
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
                    <h5>Gestionează profesorii</h5>
                    <p class="text-muted">Poți gestiona de aici profesorii din școala ta.</p>
                </div>

                <div class="col-md-12 col-lg-6">
                    @foreach ($teachers as $teacher)
                        <div class="card shadow-lg my-1">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>{{ $teacher->user->name }}</div>
                                <div>
                                    <form action="{{ route('teachers.destroy', ['school' => $school->id, 'teacher' => $teacher->id]) }}" method="POST" class="d-inline-flex mx-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Elimină</button>
                                    </form>

                                    <a class="text-royal text-decoration-none mx-1" href="{{ route('teachers.show', ['school' => $school->id, 'teacher' => $teacher->id]) }}">Editează</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $teachers->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="linkModal" tabindex="-1" aria-labelledby="linkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Obține linkul de invitație</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input id="link" type="text" value="{{ route('invite.link', $invite->code) }}" readonly class="form-control" placeholder="Copy invite link" aria-label="Copy invite link" aria-describedby="button-link">
                        <div class="input-group-append">
                            <button class="btn btn-royal" type="button" id="button-link" data-clipboard-target="#link">Copiază linkul</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('teachers.renew', ['school' => $school->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-royal">Generează un nou link  <i class="fas fa-link"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
