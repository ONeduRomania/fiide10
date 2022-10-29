@extends('layouts.dashboard')

@section('pageName')
    {{__('Gestionează utilizatorii')}}
@endsection

@section('content')
    <div class="section-info">
        <div class="container-fluid">
            <x-alert/>
            <div class="col">
                <div class="row d-flex justify-content-center mb-3">
                    <a href="{{ route('users.create') }}" class="btn btn-link text-royal">
                        {{__("Creează un utilizator nou")}} <i class="fas fa-plus"></i>
                    </a>
                    <a href="{{ route('users.deleted') }}" class="btn btn-link text-royal">
                        Vezi utilizatori șterși <i class="fas fa-user-times"></i>
                    </a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Rol principal</th>
                        <th>Acțiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->roles[0]->name }}</td>
                            <td>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                      class="d-inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger">Șterge</button>
                                </form>
                                <a class="btn btn-link text-royal" href="{{ route('users.show', $user->id) }}">Vezi
                                    detalii</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
