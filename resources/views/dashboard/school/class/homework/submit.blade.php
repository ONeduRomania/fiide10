@extends('layouts.dashboard')

@section('content')
    <div class="section-info d-flex align-items-center my-5">
        <div class="container-fluid">
            <x-alert></x-alert>
            <div class="container">
                <h5> Tema: {{ $homework->name }}</h5>
                <p class="text-muted">De aici poți trimite tema ta.</p>

                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <form method="POST" class="dropzone" id="homework-submit-form"
                                      action="{{ route('homework.submit_post', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id, 'homework' => $homework->id]) }}">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script defer>
        const uploadedFiles = {!! $uploadedUrls !!};
        document.addEventListener('DOMContentLoaded', function () {
            window.Dropzone.options.homeworkSubmitForm = {
                dictDefaultMessage: "Trage un fișier sau dă click pentru a selecta unul.",
                dictRemoveFileConfirmation: "Ești sigur(ă) că vrei să ștergi acest fișier?",
                addRemoveLinks: true,
                maxFilesize: {{ env("MAX_HOMEWORK_FILESIZE_KB", 51200) / 1024 }}, // This is in megabytes
                acceptedFiles: {!! stripcslashes($mimeTypes) !!},
                init: function () {
                    const thDr = this;
                    this.on("removedfile", function (file) {
                        // TODO: Șterge fișierul din db
                        console.log("Removed file " + file);
                    });

                    uploadedFiles.forEach(function (mockFile) {
                        thDr.displayExistingFile(mockFile, 'https://img.icons8.com/ios/50/000000/placeholder-thumbnail-document.png');
                    })
                },
            }


        })


    </script>
@endsection
