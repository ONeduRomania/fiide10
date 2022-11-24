<div>
    {{--    TODO: Infer parameters from profile --}}
    {{--        <a class="nav-item nav-link" href="{{ route('classes.log') }}">{{ __('Clasele mele') }}</a>--}}
    <a class="nav-item nav-link" href="{{ route('classes.index', ['school' => $schoolId]) }}">{{ __('Clasele mele') }}</a>
    {{--        <a class="nav-item nav-link" href="{{ route('homework.show_all') }}">{{ __('Sarcini de lucru') }}</a>--}}
    <a class="nav-item nav-link" href="{{ route('home') }}">{{ __('Sarcini de lucru') }}</a>
    <a class="nav-item nav-link" href="{{ route('home') }}">{{ __('Orar') }}</a>
    {{--        <a class="nav-item nav-link" href="{{ route('timetable.show') }}">{{ __('Orar') }}</a>--}}
    <a class="nav-item nav-link" href="https://onedu.ro/voluntariaza">{{ __('Voluntariat') }}</a>
</div>
