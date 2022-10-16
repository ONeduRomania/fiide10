@extends('layouts.dashboard')

@section('pageName')
    {{__('Școli șterse')}}
@endsection

@section('content')
    <div class="section-info">
        <div class="container-fluid">
            <x-alert />
            <div class="container">
                <p class="text-muted">Poți să restaurezi școala sau să o ștergi definitiv. Nu uita, ai doar 30 de zile să te răzgândești.</p>

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
                                <form action="{{ route('schools.force', $school->id) }}" method="POST" class="d-inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger">{{__('Șterge definitiv')}}</button>
                                </form>
                                <form action="{{ route('schools.restore', $school->id) }}" method="POST" class="d-inline-flex">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-link text-royal">{{__('Restaurează')}}</button>
                                </form>
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
