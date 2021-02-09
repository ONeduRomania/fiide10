@extends('layouts.dashboard')

@section('content')
<div class="section-info my-5">
@can('manage-users')
                        <a class="dropdown-item text-md-center" href="{{ route('users.index') }}">	                        <a class="dropdown-item text-md-center" href="{{ route('users.index') }}">
                            {{ __('Manage all the users') }} <i class="fas fa-users-cog"></i>	                            {{ __('Administrează toți utilizatorii') }} <i class="fas fa-users-cog"></i>
                        </a>	                        </a>
                        @endcan	                        @endcan
</div>
@endsection
