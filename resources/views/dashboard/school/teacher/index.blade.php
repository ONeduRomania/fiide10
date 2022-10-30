@extends('dashboard.admin.schools.show')

@section('pageName')
    {{ $school->name }} - {{__('Profesori')}}
@endsection

@section('subcontent')
    <div class="section-info">
        <div class="container-fluid">
            <div class="col">
                <div class="row d-flex justify-content-center mb-3">
                    <button href="#" data-target="#linkModal" data-toggle="modal" class="btn btn-link text-royal">
                        {{__("Invită un profesor nou")}} <i class="fas fa-plus"></i>
                    </button>
                </div>
                @if(!$requests->isEmpty())
                    <div class="row">
                        <h4>Cereri în așteptare</h4>
                    </div>
                    <div class="row">
                        <p class="text-muted">Dacă un profesor a accesat link-ul de invitație, îi vei putea aproba cererea de aici.</p>
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
                                        <form action="{{ route('teachers.removerequest', ['school' => $school->id, 'request' => $request->id]) }}" method="POST"
                                              class="d-inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger">Nu îl recunosc.</button>
                                        </form>
                                        <form action="{{ route('teachers.acceptrequest', ['school' => $school->id, 'request' => $request->id]) }}" method="POST"
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
                    <h4>Profesori activi</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nume</th>
                            <th>Acțiuni</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->user->name }}</td>
                                <td>
                                    <form action="{{ route('teachers.destroy', ['school' => $school->id, 'teacher' => $teacher->id]) }}" method="POST"
                                          class="d-inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger">Șterge</button>
                                    </form>
                                    <a class="btn btn-link text-royal" href="{{ route('teachers.show', ['school' => $school->id, 'teacher' => $teacher->id]) }}">Editează</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $teachers->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="linkModal" tabindex="-1" aria-labelledby="linkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Invită un profesor nou</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Trimite acest link profesorului pe care dorești să îl inviți, iar după ce acesta se loghează în platformă va apărea în lista de mai jos.</p>
                    <div class="input-group mb-3">
                        <input id="link" type="text" value="{{ route('invite.link', $invite->code) }}" readonly class="form-control" placeholder="Copy invite link" aria-label="Copy invite link" aria-describedby="button-link">
                        <div class="input-group-append">
                            <button class="btn btn-royal" type="button" id="button-link" data-clipboard-target="#link">Copiază linkul</button>
                        </div>
                    </div>
                    <p class="text-muted">În caz că vrei să anulezi linkul de invitație și să generezi una nouă, apasă pe butonul de mai jos.</p>
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
