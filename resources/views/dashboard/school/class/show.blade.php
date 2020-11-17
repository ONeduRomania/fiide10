@extends('layouts.dashboard')

@section('content')
    <div class="section-info d-flex align-items-center my-5">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert" role="alert">
                    <button type="button" class="btn btn-royal dismissible" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                    <div class="my-1 text-center">
                        <p class="text-white">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert" role="alert">
                    <button type="button" class="btn btn-danger dismissible" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                    <div class="my-1 text-center">
                        <p class="text-white">
                            <strong>{{ __('Error: ') }}</strong> {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif
            <div class="container">
                <h5>{{ __('Show class data') }}: {{ $class->name }}</h5>
                <p class="text-muted">{{ __('From here you can edit the subject\'s data or see the subject\'s data.') }}</p>

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card shadow-lg">
                            <form method="POST" action="{{ route('classes.update', ['school' => $school->id, 'class' => $class->id]) }}">
                                <div class="card-body">
                                    @method('PATCH')
                                    @csrf
                                    <div class="form-group">
                                        <label for="name" class="text-md-left">{{ __('Name of the class') }}</label>

                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ __('Enter class name...') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="master_teacher" class="text-md-left">{{ __('Select class\' master teacher ') }}</label>

                                        <select id="master_teacher" name="master_teacher" class="form-control @error('master_teacher') is-invalid @enderror" required autofocus>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->user->id }}">{{ $teacher->user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('master_teacher')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-gray">{{ __('Edit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="card shadow-lg">
                            <div class="card-body d-flex justify-content-center">
                                <small class="text-muted">{{ __('If you want to edit more details about this school you can go right here: ') }}<a class="text-decoration-none text-primary" href="">Edit <i class="fas fa-edit"></i></a></small>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-3" />

                <div class="row">
                    <div class="col-md-12 col-lg-12 text-center">
                        <h5>{{ __('Invite new student') }}</h5>
                        <p class="text-muted">{{ __('Here you can invite a new student to your school.') }}</p>
                        <button type="button" class="btn btn-block btn-royal" data-toggle="modal" data-target="#linkModal">{{ __('Get the invite link.') }} <i class="fas fa-link"></i></button>
                    </div>
                </div>

                <hr class="my-3" />
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <h5>{{ __('In pending requests to join') }}</h5>
                        <p class="text-muted">{{ __('If you want to accept or decline a request from a student to join your class do it here.') }}</p>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        @foreach ($requests as $request)
                            <div class="card shadow-lg my-1">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>{{ $request->user->name }}</div>
                                    <div>
                                        <form action="{{ route('classes.removerequest', ['school' => $school->id, 'class' => $class->id, 'request' => $request->id]) }}" method="POST" class="d-inline-flex mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{ __('Decline') }}</button>
                                        </form>

                                        <form action="{{ route('classes.acceptrequest', ['school' => $school->id, 'class' => $class->id, 'request' => $request->id]) }}" method="POST" class="d-inline-flex mx-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success">{{ __('Accept') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{ $requests->links() }}
                    </div>
                </div>

                <hr class="my-3" />
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <h5>{{ __('Manage your students') }}</h5>
                        <p class="text-muted">{{ __('If you want to manage your students (remove) them you can do it here.') }}</p>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        @foreach ($students as $student)
                            <div class="card shadow-lg my-1">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>{{ $student->user->name }}</div>
                                    <div>
                                        <form action="{{ route('teachers.destroy', ['school' => $school->id, 'teacher' => $teacher->id]) }}" method="POST" class="d-inline-flex mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{ __('Remove') }}</button>
                                        </form>

                                        <a class="text-royal text-decoration-none mx-1" href="{{ route('teachers.show', ['school' => $school->id, 'teacher' => $teacher->id]) }}">{{ __('Edit') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{ $students->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="linkModal" tabindex="-1" aria-labelledby="linkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Get the invite link') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input id="link" type="text" value="{{ route('invite.link', $invite->code) }}" readonly class="form-control" placeholder="Copy invite link" aria-label="Copy invite link" aria-describedby="button-link">
                        <div class="input-group-append">
                            <button class="btn btn-royal" type="button" id="button-link" data-clipboard-target="#link">{{ __('Copy') }}</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('classes.renew', ['school' => $school->id, 'class' => $class->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-royal">{{ __('Regenerate') }}  <i class="fas fa-link"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
