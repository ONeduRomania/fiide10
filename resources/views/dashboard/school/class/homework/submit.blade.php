@extends('dashboard.admin.schools.show')

@section('pageName')
Tema: {{ $homework->name }}
@endsection

@section('subcontent')
<div class="section-info">
    <div class="container-fluid">
        <div class="col">
            <p>Apasă pe caseta de mai jos pentru a adăuga fișiere.</p>
            <form method="POST" class="dropzone" id="homework-submit-form" action="{{ route('homework.submit_post', ['school' => $school->id, 'class' => $class->id, 'subject' => $subject->id, 'homework' => $homework->id]) }}">
                @csrf
            </form>
            <form method="POST" id="homework-delete-form" action="{{ route('homework.submit_delete_file', ['school' => $school->id, 'class' => $class->id, 'subject' => $subject->id, 'homework' => $homework->id]) }}">
                @csrf
                <input type="hidden" name="file_name" id="file_name_input" />
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script defer>
    const uploadedFiles = {!!$uploadedUrls!!};
    console.log(uploadedFiles)
    document.addEventListener('DOMContentLoaded', function() {
        window.Dropzone.options.homeworkSubmitForm = {
            dictDefaultMessage: "Trage un fișier sau dă click pentru a selecta unul.",
            dictRemoveFileConfirmation: "Ești sigur(ă) că vrei să ștergi acest fișier?",
            addRemoveLinks: true,
            maxFilesize: {{env("MAX_HOMEWORK_FILESIZE_KB", 51200) / 1024}}, // This is in megabytes
            acceptedFiles: {!!stripcslashes($mimeTypes) !!},
            init: function() {
                const thDr = this;
                this.on("removedfile", function(file) {
                    const formObject = document.getElementById("file_name_input");
                    formObject.value = file.name;
                    formObject.parentElement.submit();
                });

                uploadedFiles.forEach(function(mockFile) {
                    thDr.displayExistingFile(mockFile, "{{ URL::asset('images/placeholder-thumbnail-document.png')  }}");
                })
            },
        }


    })
</script>
@endsection
