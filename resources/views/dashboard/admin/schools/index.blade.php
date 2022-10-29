@extends('layouts.dashboard')

@section('pageName')
    {{__('Gestionează școlile')}}
@endsection

@section('content')
    <div class="section-info">
        <div class="container-fluid">
            <x-alert/>
            <div class="col">
                <div class="row d-flex justify-content-center mb-3">
                    <a href="{{ route('schools.create') }}" class="btn btn-link text-royal">
                        {{__("Creează școală nouă")}} <i class="fas fa-plus"></i>
                    </a>
                    <a href="{{ route('schools.deleted') }}" class="btn btn-link text-royal">
                        Vezi școli șterse <i class="fas fa-user-times"></i>
                    </a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nume școală</th>
                        <th>Mail de contact</th>
                        <th>Acțiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($schools as $school)
                        <tr>
                            <td>{{ $school->name }}</td>
                            <td>{{ $school->email_contact }}</td>
                            <td>
                                <form action="{{ route('schools.destroy', $school->id) }}" method="POST"
                                      class="d-inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger">Șterge</button>
                                </form>
                                <a class="btn btn-link text-royal" href="{{ route('schools.show', $school->id) }}">Vezi
                                    detalii</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $schools->links() }}
            </div>
        </div>
    </div>
@endsection
