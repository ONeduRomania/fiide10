@extends('layouts.dashboard')

@section('pageName')
    {{$school->name}}
    <span><a href="{{ route('schools.edit', $school->id) }}" class="btn btn-link">
                    {{__("Editează")}}
                </a></span>
@endsection

@section('content')
    <div class="section-info">
        <div class="container-fluid">
            <x-alert/>
            <div class="col">
                {{--                <div class="row">--}}
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item">
                        <a class="nav-link @menuInactive('classes.index', 'text-royal') @menuActive('classes.index', 'active')"
                           href="{{ route('classes.index', $school->id) }}">Clase</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @menuInactive('teachers.index', 'text-royal') @menuActive('teachers.index', 'active')"
                           href="{{ route('teachers.index', $school->id) }}">Profesori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @menuInactive('subjects.index', 'text-royal') @menuActive('subjects.index', 'active')"
                           href="{{ route('subjects.index', $school->id) }}">Materii</a>
                    </li>
                </ul>
                {{--                </div>--}}
                @yield('subcontent')
            </div>
        </div>
    </div>
@endsection
