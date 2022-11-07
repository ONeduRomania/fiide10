@extends('dashboard.admin.schools.show')

@section('pageName')
    {{ $class->name }}
    <span><a href="{{ route('classes.edit', ['school' => $school->id, 'class' => $class->id]) }}" class="btn btn-link">
                    {{__("Editează")}}
                </a></span>
@endsection

@section('subcontent')
    <div class="section-info">
        <div class="container-fluid">
            <div class="col">
                <div class="row d-flex justify-content-center mb-3">
                    <button href="#" data-target="#linkModal" data-toggle="modal" class="btn btn-link text-royal">
                        {{__("Invită un elev nou")}} <i class="fas fa-plus"></i>
                    </button>
                    <a class="btn btn-link text-royal"
                       href="{{ route('timetable.index', ['school' => $school->id, 'class' => $class->id]) }}">Editează orarul <i
                            class="fas fa-edit"></i></a>
                    <a
                        class="btn btn-link text-royal"
                        href="{{ route('log.create', ['school' => $school->id, 'class' => $class->id]) }}">Adaugă intrare în catalog <i class="fas fa-link"></i></a>
                </div>
                @if(!$requests->isEmpty())
                    <div class="row">
                        <h4>Cereri în așteptare</h4>
                    </div>
                    <div class="row">
                        <p class="text-muted">Dacă un elev a accesat link-ul de invitație, îi vei putea aproba cererea de aici.</p>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Nume</th>
                                <th>Acțiuni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($requests as $request)
                                <tr>
                                    <td>{{ $request->user->name }}</td>
                                    <td>
                                        <form action="{{ route('classes.removerequest', ['school' => $school->id, 'class' => $class->id, 'request' => $request->id]) }}" method="POST"
                                              class="d-inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger">Nu îl recunosc.</button>
                                        </form>
                                        <form action="{{ route('classes.acceptrequest', ['school' => $school->id, 'class' => $class->id, 'request' => $request->id]) }}" method="POST"
                                              class="d-inline-flex">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-link text-success">Permite</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $requests->links() }}
                    </div>
                @endif
                <div class="row">
                    <h4>Vezi elevii</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nume</th>
                            <th>Acțiuni</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->user->name }}</td>
                                <td>
                                    <form action="{{ route('classes.student.destroy', ['school' => $school->id, 'class' => $class->id, 'student' => $student->id]) }}" method="POST"
                                          class="d-inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger">Șterge</button>
                                    </form>
                                    <a class="btn btn-link text-royal" href="{{ route('classes.student.show', ['school' => $school->id, 'class' => $class->id, 'student' => $student->id]) }}">Editează</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="linkModal" tabindex="-1" aria-labelledby="linkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Invită elevii noi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Trimite acest link elevilor pe care dorești să îî inviți, iar după ce aceștia se loghează în platformă vor apărea în lista de mai jos.</p>
                    <div class="input-group mb-3">
                        <input id="link" type="text" value="{{ route('invite.link', $invite->code) }}" readonly class="form-control" placeholder="Copiază linkul" aria-label="Copiază linkul" aria-describedby="button-link">
                        <div class="input-group-append">
                            <button class="btn btn-royal" type="button" id="button-link" data-clipboard-target="#link">Copiază linkul</button>
                        </div>
                    </div>
                    <p class="text-muted">În caz că vrei să anulezi linkul de invitație și să generezi unul nou, apasă pe butonul de mai jos.</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('classes.renew', ['school' => $school->id, 'class' => $class->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-royal">Generează un nou link  <i class="fas fa-link"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
