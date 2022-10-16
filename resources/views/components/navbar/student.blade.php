<div>
{{--    TODO: Infer parameters from profile --}}
    <li class="nav-item">
{{--        <a class="nav-link" href="{{ route('classes.log') }}">{{ __('Situația școlară') }}</a>--}}
        <a class="nav-link" href="{{ route('home') }}">{{ __('Situația școlară') }}</a>
    </li>
    <li class="nav-item">
{{--        <a class="nav-link" href="{{ route('homework.show_student_homework') }}">{{ __('Sarcini de lucru') }}</a>--}}
        <a class="nav-link" href="{{ route('home') }}">{{ __('Sarcini de lucru') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">{{ __('Orar') }}</a>
{{--        <a class="nav-link" href="{{ route('timetable.show') }}">{{ __('Orar') }}</a>--}}
    </li>
    <li class="nav-item">
        <a class="nav-link" href="https://onedu.ro/voluntarizaza">{{ __('Voluntariat') }}</a>
    </li>
</div>
