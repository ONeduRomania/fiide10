@extends('layouts.dashboard')

@section('content')
    <div class="section-info d-flex align-items-center my-5">
        <div class="container-fluid">
            <x-alert></x-alert>
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
                                        <form
                                            action="{{ route('homework.delete', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id, 'homework' => $homework->id]) }}"
                                            method="POST" class="d-inline-flex mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                Elimină
                                            </button>
                                        </form>

                                        <a class="text-royal text-decoration-none mx-1"
                                           href="{{ route('homework.check', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id, 'homework' => $homework->id]) }}">Editează</a>
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
                        <x-homework-form></x-homework-form>
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
    <script type="text/javascript">
        window.addEventListener('load', function () {
            @if (count($errors) > 0)
            // Show the modal if an error occurred, so the user knows the operation is not successful.
            window.$('#homeworkModal').modal('show');
            @endif

            // Ask before deleting the homework.
            window.$(document).on("submit", "form", function () {
                if (window.$('#homeworkModal').is(':visible')) {
                    // We don't want to ask the user when creating new homework.
                    return true;
                }
                return confirm("Ești sigur că vrei să ștergi această temă?");
            });
        });
    </script>
@endsection
