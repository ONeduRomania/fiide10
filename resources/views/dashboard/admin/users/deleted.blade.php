@extends('layouts.dashboard')

@section('pageName')
    {{__('Utilizatori șterși')}}
@endsection

@section('content')
    <div class="section-info">
        <div class="container-fluid">
            <x-alert/>
            @if($users->isEmpty())
                <p>Nu există utilizatori șterși momentan. Poți accesa lista de utilizatori activi <a
                        href="{{ route('users.index') }}" class="text-royal">aici.</a></p>
            @else
                <div class="col">
                    <p class="text-muted">Poți să restaurezi utilizatorul sau să îl ștergi definitiv. Nu uita, ai doar
                        30 de
                        zile să te răzgândești.</p>

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
                                    <form action="{{ route('users.force', $user->id) }}" method="POST"
                                          class="d-inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-link text-danger">{{__('Șterge definitiv')}}</button>
                                    </form>
                                    <form action="{{ route('users.restore', $user->id) }}" method="POST"
                                          class="d-inline-flex">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="btn btn-link text-royal">{{__('Restaurează')}}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
