<div>
{{--    TODO: Infer parameters from profile --}}
    <li class="nav-item">
{{--        <a class="nav-link" href="{{ route('classes.log') }}">{{ __('Clasele mele') }}</a>--}}
        <a class="nav-link" href="{{ route('classes.show') }}">{{ __('Clasele mele') }}</a>
    </li>
    <li class="nav-item">
{{--        <a class="nav-link" href="{{ route('homework.show_all') }}">{{ __('Sarcini de lucru') }}</a>--}}
        <a class="nav-link" href="{{ route('home') }}">{{ __('Sarcini de lucru') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">{{ __('Orar') }}</a>
{{--        <a class="nav-link" href="{{ route('timetable.show') }}">{{ __('Orar') }}</a>--}}
    </li>
    <li class="nav-item">
        <a class="nav-link" href="https://onedu.ro/voluntariaza">{{ __('Voluntariat') }}</a>
    </li>
</div>
