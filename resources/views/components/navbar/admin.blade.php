<div>
    <a class="nav-item nav-link" href="{{ route('schools.index') }}">{{ __('Școli') }}</a>
    <a class="nav-item nav-link" href="{{ route('users.index', ['type' => 'student']) }}">{{ __('Elevi') }}</a>
    <a class="nav-item nav-link" href="{{ route('users.index', ['type' => 'teacher']) }}">{{ __('Profesori') }}</a>
    <a class="nav-item nav-link" href="{{ route('users.index') }}">{{ __('Contractul dvs.') }}</a>
</div>
