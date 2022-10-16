<div>
    <a class="nav-item nav-link" href="{{ route('schools.index') }}">{{ __('Școli') }}</a>
    <a class="nav-item nav-link" href="{{ route('users.index') }}">{{ __('Elevi') }}</a>
    {{--      TODO: Discriminează      --}}
    <a class="nav-item nav-link" href="{{ route('users.index') }}">{{ __('Profesori') }}</a>
    <a class="nav-item nav-link" href="{{ route('users.index') }}">{{ __('Contractul dvs.') }}</a>
</div>
