@extends('dashboard.admin.schools.show')

@section('pageName')
    {{$school->name}} - {{__('Materii')}}
@endsection

@section('subcontent')
    <div class="section-info">
        <div class="container-fluid">
            <div class="col">
                <div class="row d-flex justify-content-center mb-3">
                    <a href="{{ route('subjects.create', $school->id) }}" class="btn btn-link text-royal">
                        {{__("Creează o materie nouă")}} <i class="fas fa-plus"></i>
                    </a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Acțiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>{{ $subject->name }}</td>
                            <td>
                                <form action="{{ route('subjects.destroy', ['school' => $school->id, 'subject' => $subject->id]) }}" method="POST"
                                      class="d-inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger">Șterge</button>
                                </form>
                                <a class="btn btn-link text-royal" href="{{ route('subjects.show', ['school' => $school->id, 'subject' => $subject->id]) }}">Editează</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $subjects->links() }}
            </div>
        </div>
    </div>
@endsection
