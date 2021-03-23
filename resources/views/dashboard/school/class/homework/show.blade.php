@extends('layouts.dashboard')

@section('content')
    <div class="section-info d-flex align-items-center my-5">
        <div class="container-fluid">
            <x-alert></x-alert>
            <div class="container">
                <h5> Tema: {{ $homework->name }}</h5>
                <p class="text-muted">De aici poți edita detaliile temei.</p>

                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <form method="POST"
                                      action="{{ route('homework.update', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id, 'homework' => $homework->id]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <x-homework-form :homework="$homework"></x-homework-form>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-gray">Editează</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-3"/>
                <div class="row">
                    <div class="col-12">
                        <h5>Verifică temele trimise</h5>
                        <p class="text-muted">De aici poți vedea temele trimise de elevi până în prezent. Temele marcate cu roșu au fost trimise după data limită.</p>

                        @foreach($homework->submissions as $submittedHomework)
                            <div class="card shadow-lg my-1">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        @if ($submittedHomework->student != null)
                                            {{ $submittedHomework->student->user->name }}
                                        @endif
                                        <br/>
                                        <small class="text-muted">Data trimiterii:
                                            <strong style="{{ strtotime($submittedHomework->created_at) > strtotime($homework->due_date) ? "color: red" : "" }}">{{ $submittedHomework->created_at }}</strong></small>
                                        <br/>
                                        <small
                                            class="text-muted"><strong>{{ count(json_decode($submittedHomework->uploaded_urls, true)) }}</strong>
                                            fișiere încărcate</small>
                                    </div>
                                    <div>
                                        <form
                                            action="{{ route('homework.download_submission', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id, 'homework' => $homework->id, 'submission' => $submittedHomework->id]) }}"
                                            method="GET" class="d-inline-flex mx-1">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Descarcă</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="snackbar">Descărcarea fișierelor va începe în curând...</div>
@endsection

@section('scripts')
    <script>
        window.addEventListener('load', function () {
            // Announce to the user that the download will start
            window.$(document).on("submit", "form", function (e) {
                if (e.target.method !== "get") {
                    // Don't show this when updating the homework itself.
                    return true;
                }
                const snackbarRef = window.$('#snackbar');
                snackbarRef.addClass('show');
                setTimeout(function () {
                    snackbarRef.removeClass('show')
                }, 3000);
            });
        });
    </script>
@endsection

