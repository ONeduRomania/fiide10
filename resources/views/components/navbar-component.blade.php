<nav {{$attributes}}>
    <div style="margin-left: auto; margin-right: auto">
        <a href="{{ route('home') }}"><img id="logo" src="{{asset('images/logo.webp')}}" alt="Logo Fii de 10"/></a>
        <a class=" nav-item nav-link" href="{{ route('home') }}">{{ __('Noutăți') }}</a>
        @role('admin')
        <x-navbar.admin/>
        @endrole
        @role('student')
        <x-navbar.student schoolId="{{$schoolId}}" classId="{{$classId}}" studentId="{{$studentId}}"/>
        @endrole
        @role('teacher')
        <x-navbar.teacher schoolId="{{$schoolId}}"/>
        @endrole
    </div>
</nav>
