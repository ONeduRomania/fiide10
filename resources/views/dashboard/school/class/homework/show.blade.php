@extends('dashboard.admin.schools.show')

@section('pageName')
    {{$homework->name}}
@endsection

@section('subcontent')
    <div class="section-info">
        <div class="container-fluid">
            <x-alert/>
            <div class="col">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nume elev</th>
                        <th>Data trimiterii</th>
                        <th>Numar de fisiere</th>
                        <th>Acțiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($submissions as $submittedHomework)
                        <tr>
                            <!-- TODO: Color red if time is passed -->
                            <td>{{ $submittedHomework->student?->user?->name ?? "Elev sters" }}</td>
                            <td>{{ $submittedHomework->created_at }}</td>
                            <td>{{ count(json_decode($submittedHomework->uploaded_urls, true)) }} }}</td>
                            <td>
                            <form
                                            action="{{ route('homework.download_submission', ['school' => $school->id, 'class' => $class->id, 'homework' => $homework->id, 'submission' => $submittedHomework->id]) }}"
                                            method="GET" class="d-inline-flex">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-royal">Descarca</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $submissions->links() }}
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
