@extends('dashboard.admin.schools.show')

@section('pageName')
    {{$class->name}} - {{__('Teme')}}
@endsection

@section('subcontent')
    <div class="section-info">
        <div class="container-fluid">
            <div class="col">
                <div class="row d-flex justify-content-center mb-3">
                    <a href="{{ route('homework.create', ['school' => $school->id, 'class' => $class->id]) }}"
                       class="btn btn-link text-royal">
                        {{__("Creează o temă nouă")}} <i class="fas fa-plus"></i>
                    </a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Dată limită</th>
                        <th>Teme trimise</th>
                        <th>Acțiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($homeworks as $homework)
                        <tr>
                            <td>{{ $homework->name }}</td>
                            <td>{{ $homework->due_date }}</td>
                            <td>{{ $homework->submissions_count }}</td>
                            <td>
                                <form
                                    action="{{ route('homework.destroy', ['school' => $school->id, 'class' => $class->id, 'homework' => $homework->id]) }}]) }}"
                                    method="POST"
                                    class="d-inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger">Șterge</button>
                                </form>
                                <a class="btn btn-link text-royal"
                                   href="{{ route('homework.edit', ['school' => $school->id, 'class' => $class->id, 'homework' => $homework->id]) }}">Editează</a>
                                <a class="btn btn-link text-royal"
                                   href="{{ route('homework.show', ['school' => $school->id, 'class' => $class->id, 'homework' => $homework->id]) }}">Vezi
                                    teme</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $homeworks->links() }}
            </div>
        </div>
    </div>
@endsection
