@extends('layouts.dashboard')

@section('content')
<div class="section-info my-5">
@can('manage-users')
<a class="dropdown-item text-md-center" href="{{ route('users.index') }}">
{{ __('Administrează toți utilizatorii') }} <i class="fas fa-users-cog"></i>
 </a>
@endcan
</div>
@endsection
