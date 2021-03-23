@extends('layouts.dashboard')

@section('content')
    <div class="section-info d-flex align-items-center my-5">
        <div class="container-fluid">
            <x-alert></x-alert>

            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 text-center">
                        <h5>Vezi temele tale</h5>
                        <p class="text-muted">De aici poți vedea ce teme ai primit.</p>
                        <div>

                        </div>
                        <form action="{{ route('homework.show_student_homework', ['school' => $school->id, 'classroom' => $classroom->id]) }}">
                            @if (!$shouldShowAll)
                                <input type="hidden" name="all" value="1" />
                            @endif
                            <button type="submit" class="btn btn-block btn-royal">
                                @if($shouldShowAll)
                                    Vezi doar temele noi
                                @else
                                    Vezi toate temele
                                @endif
                                <i class="fas fa-swatchbook"></i>
                            </button>
                        </form>

                    </div>
                </div>

                <hr class="my-3"/>
                <div class="row">
                    <div class="col-12 text-center">
                        @foreach ($homeworks as $homework)
                            <div class="card shadow-lg my-1">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ $homework->name }}
                                        <br/>
                                        <small class="text-muted">Dată limită:
                                            <strong style="{{ !$shouldShowAll && strtotime('now') > strtotime($homework->due_date) ? "color: red" : "" }}">{{ $homework->due_date  }}</strong></small>
                                        <br/>
                                        <small class="text-muted">Materie: <strong>{{ $homework->subject->name }}</strong></small>
                                    </div>
                                    <div>
                                        <a class="btn btn-primary" href="{{ route('homework.submit_get', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $homework->subject->id, 'homework' => $homework->id]) }}">
                                            Trimite
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
