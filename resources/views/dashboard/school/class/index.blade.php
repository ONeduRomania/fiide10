@extends('dashboard.admin.schools.show')

@section('pageName')
    {{$school->name}} - {{__('Clase')}}
    <span><a href="{{ route('schools.edit', $school->id) }}" class="btn btn-link">
            {{__("Editează")}}
        </a></span>
    @endsection

    @section('subcontent')
        <div class="section-info">
            <div class="container-fluid">
                <div class="col">
                    <div class="row d-flex justify-content-center mb-3">
                        <a href="{{ route('classes.create', $school->id) }}" class="btn btn-link text-royal">
                            {{__("Creează o clasă nouă")}} <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Număr clasă</th>
                                <th>Diriginte</th>
                                <th>Acțiuni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $class)
                                <tr>
                                    <td>{{ $class->name }}</td>
                                    <td>{{ $class->masterTeacher->name }}</td>
                                    <td>
                                        <form action="{{ route('classes.destroy', ['school' => $school->id, 'class' => $class->id]) }}" method="POST"
                                                                                                                                        class="d-inline-flex">
                                                                                                                                        @csrf
                                                                                                                                        @method('DELETE')
                                                                                                                                        <button type="submit" class="btn btn-link text-danger">Șterge</button>
                                        </form>
                                        <a class="btn btn-link text-royal" href="{{ route('classes.show', ['school' => $school->id, 'class' => $class->id]) }}">Vezi
                                            elevi</a>
                                            <a class="btn btn-link text-royal" href="{{ route('homework.index', ['school' => $school->id, 'class' => $class->id]) }}">Vezi
                                                teme</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @isset($classes->links)
                        {{ $classes->links() }}
                    @endisset
                </div>
            </div>
        </div>
    @endsection
