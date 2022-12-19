@extends('dashboard.admin.schools.show')

@section('pageName')
    @if (isset($class))
        {{ $class->name }} - Orar
        <span><a href="{{ route('classes.show', ['school' => $school->id, 'class' => $class->id]) }}" class="btn btn-link">
                {{ __('Înapoi') }}
            </a></span>
    @else
        Orar
    @endif
@endsection
@section('subcontent')
    <div class="section-info">
        <div class="container-fluid">
            <div class="col">
                <div class="row">
                    <p class="text-muted">Dacă dorești să adaugi o nouă oră de curs în orar, apasă pe un spațiu gol. Dacă
                        apeși pe o oră existentă o poți edita sau șterge, și o poți muta trăgând cu mouse-ul.</p>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 text-center">
                        @if (isset($class))
                            <div id="timetable-component"
                                data-createurl="{{ route('timetable.store', ['school' => $school->id, 'class' => $class->id]) }}"
                                data-updateurl="{{ route('timetable.update', ['school' => $school->id, 'class' => $class->id, 'timetable' => ':timetable_id']) }}"
                                data-deleteurl="{{ route('timetable.destroy', ['school' => $school->id, 'class' => $class->id, 'timetable' => ':timetable_id']) }}"
                                data-timetable="{{ $timetables }}" data-subjects="{{ $subjects }}"
                                data-teachers="{{ $teachers }}"></div>
                        @else
                            <div id="timetable-component" data-timetable="{{ $timetables }}"
                                data-subjects="{{ $subjects }}" data-teachers="{{ $teachers }}"></div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ mix('js/timetable.js') }}" defer></script>
@endsection
