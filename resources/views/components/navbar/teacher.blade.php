<div>
    <a class="nav-item nav-link" href="{{ route('classes.index', ['school' => $schoolId]) }}">{{ __('Clasele mele') }}</a>
    <a class="nav-item nav-link" href="{{ route('subjects.index', ['school' => $schoolId]) }}">{{ __('Materii') }}</a>
    <a class="nav-item nav-link" href="{{ route('teachers.timetable', ['school' => $schoolId]) }}">{{ __('Orar') }}</a>
    <a class="nav-item nav-link" href="https://onedu.ro/voluntariaza">{{ __('Voluntariat') }}</a>
    <a href="{{ route('logout') }}" class="nav-item nav-link">{{ __('Deconectare') }}</a>
</div>
