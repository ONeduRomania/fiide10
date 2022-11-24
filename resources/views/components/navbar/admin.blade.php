<div>
    <a class="nav-item nav-link" href="{{ route('schools.index') }}">{{ __('Școli') }}</a>
    <a class="nav-item nav-link" href="{{ route('users.index', ['type' => 'student']) }}">{{ __('Elevi') }}</a>
    <a class="nav-item nav-link" href="{{ route('users.index', ['type' => 'teacher']) }}">{{ __('Profesori') }}</a>
    <a class="nav-item nav-link" href="{{ route('users.index') }}">{{ __('Contractul dvs.') }}</a>
    <form method="POST" action="{{ route('logout') }}">
        <a onclick="this.parentNode.submit()" class="nav-item nav-link">{{ __('Deconectare') }}</a>
    </form>
</div>
