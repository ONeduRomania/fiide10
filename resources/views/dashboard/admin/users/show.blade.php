@extends('layouts.dashboard')

@section('pageName')
    {{$user->name}}
@endsection

@section('content')
    <div class="section-info">
        <div class="container-fluid">
            <x-alert />
            <div class="col">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                    {{__("Editează")}} <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
