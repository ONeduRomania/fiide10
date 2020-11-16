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
            </div>
        </div>
    </div>
@endsection