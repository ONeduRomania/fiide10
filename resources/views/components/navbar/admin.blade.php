<div>
    @can('manage-schools')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('schools.index') }}">{{ __('Școli') }}</a>
        </li>
    @endcan
    @can('manage-users')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">{{ __('Elevi') }}</a>
        </li>
    @endcan
    {{--      TODO: Discriminează      --}}
    @can('manage-users')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">{{ __('Profesori') }}</a>
        </li>
    @endcan
    @can('read-contract')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">{{ __('Contractul dvs.') }}</a>
        </li>
    @endcan
</div>
