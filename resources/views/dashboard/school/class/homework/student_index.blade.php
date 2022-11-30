@extends('dashboard.admin.schools.show')

@section('pageName')
    {{__('Teme')}}
@endsection

@section('subcontent')

    <div class="section-info">
        <div class="container-fluid">
            <div class="col">
                <div class="row d-flex justify-content-center mb-3">
                        <form action="{{ route('homework.show_student_homework', ['school' => $school->id, 'class' => $class->id]) }}">
                            @if (!$shouldShowAll)
                                <input type="hidden" name="all" value="1" />
                            @endif
                            <button type="submit" class="btn btn-link text-royal">
                                @if($shouldShowAll)
                                    Vezi doar temele noi
                                @else
                                    Vezi toate temele
                                @endif
                                <i class="fas fa-swatchbook"></i>
                            </button>
                        </form>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Dată limită</th>
                        <th>Materie</th>
                        <th>Acțiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($homeworks as $homework)
                        <tr>
                            <td>{{ $homework->name }}</td>
                            <td style="{{ !$shouldShowAll && strtotime('now') > strtotime($homework->due_date) ? "color: red" : "" }}">{{ $homework->due_date }}</td>
                            <td>{{ $homework->subject->name }}</td>
                            <td>
                                        <a class="btn btn-primary" href="{{ route('homework.submit_get', ['school' => $school->id, 'class' => $classroom->id, 'subject' => $homework->subject->id, 'homework' => $homework->id]) }}">
                                            Trimite
                                        </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection
