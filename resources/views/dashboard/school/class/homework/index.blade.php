@extends('layouts.dashboard')

@section('content')
    <div class="section-info d-flex align-items-center my-5">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert" role="alert">
                    <button type="button" class="btn btn-royal dismissible" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="fas fa-times"></i>
                        </span>
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
                            <strong>Eroare: </strong> {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 text-center">
                        <h5>Adaugă o nouă temă</h5>
                        <p class="text-muted">De aici se pot adăuga teme noi pentru elevi.</p>
                        <button type="button" class="btn btn-block btn-royal" data-toggle="modal"
                                data-target="#homeworkModal">Adaugă o nouă temă <i class="fas fa-swatchbook"></i>
                        </button>
                    </div>
                </div>

                <hr class="my-3"/>
                <div class="row">
                    <div class="col-md-12 col-lg-12 text-center">
                        <h5>Verifică temele</h5>
                        <p class="text-muted">De aici poți vedea temele create pentru această clasă până în prezent.</p>
                        @foreach ($homeworks as $homework)
                            <div class="card shadow-lg my-1">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ $homework->name }}
                                        <br/>
                                        <small class="text-muted">Dată limită:
                                            <strong>{{ $homework->due_date  }}</strong></small>
                                        <br/>
                                        <small class="text-muted"><strong>{{ $homework->submissions_count  }}</strong>
                                            teme trimise</small>
                                    </div>
                                    <div>
                                        <form class="d-inline-flex mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Elimină</button>
                                        </form>

                                        <a class="text-royal text-decoration-none mx-1"
                                           href="{{ route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id]) }}">Editează</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="homeworkModal" tabindex="-1" aria-labelledby="homeworkModalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form
                    action="{{ route('homework.create', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id]) }}"
                    method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="homeworkModalTitle">Adaugă o nouă temă pentru această materie.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="text-md-left">{{ __('Homework name') }}</label>

                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}"
                                   placeholder="{{ __('Enter a name for this homework...') }}" required autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="due_date" class="text-md-left">Introdu data până când trebuie trimisă
                                tema:</label>

                            <input id="due_date" type="date"
                                   class="form-control @error('due_date') is-invalid @enderror" name="due_date"
                                   value="{{ old('due_date') }}" placeholder="{{ __('Enter the due date...') }}"
                                   required>
                            @error('due_date')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-royal">Creează <i class="fas fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    {{--  Show the modal again if there was an error, so the user knows the operation is not successful.  --}}
    <script type="text/javascript">
        @if (count($errors) > 0)
        window.addEventListener('load', function () {
            window.$('#homeworkModal').modal('show');
        });
        @endif
    </script>
@endsection
