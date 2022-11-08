@extends('dashboard.admin.schools.show')

@section('pageName')
    {{$class->name}} - {{$student->user->name}}
@endsection

@section('subcontent')
    <div class="section-info">
        <div class="container-fluid">
            <x-alert/>
            <div class="col">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Materie</th>
                        <th>Note</th>
                        <th>Număr absențe</th>
                        <th>Medie</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>{{ $subject->name }}</td>
                            <td>
                                @foreach($subjectMarks[$subject->id] as $mark) <span class="student-mark">{{$mark->mark}}</span> @endforeach
                            </td>
                            <td>{{ $subjectAbsences[$subject->id] }}</td>
                            <td>{{ $subjectMean[$subject->id] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
