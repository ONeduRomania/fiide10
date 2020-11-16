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
                <h5>{{ __('Deleted users') }}</h5>
                <p class="text-muted">{{ __('From here you can restore some users or delete their accounts permanently, after 30 days their accounts are deleted forever.') }}</p>

                @foreach ($users as $user)
                    <div class="card shadow-lg my-1">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                {{ $user->name }}
                                <br/>
                                <small class="text-muted">Administrator</small>
                            </div>
                            <div>
                                <form action="{{ route('users.force', $user->id) }}" method="POST" class="d-inline-flex mx-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{ __('Recycle') }}</button>
                                </form>

                                <form action="{{ route('users.restore', $user->id) }}" method="POST" class="d-inline-flex mx-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-link text-royal text-decoration-none">{{ __('Restore') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
