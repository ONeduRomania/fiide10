@extends('dashboard.admin.schools.show')

@section('pageName')
    {{$class->name}} - {{__('Temă nouă')}}
@endsection

@section('subcontent')
    <div class="container-fluid">
        <div class="col">
            <form method="POST"
                  action="{{ route('homework.update', ['school' => $school->id, 'class' => $class->id, 'subject' => $subject->id, 'homework' => $homework->id]) }}">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="name" class="text-md-left">Nume:</label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name', $homework->name) }}" required autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="due_date" class="text-md-left">Introdu data până când trebuie trimisă
                        tema:</label>

                    <input id="due_date" type="datetime-local"
                           class="form-control @error('due_date') is-invalid @enderror" name="due_date"
                           value="{{ old('due_date', $homework->due_date) }}" placeholder="Introdu data aici..."
                           required>
                    @error('due_date')
                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Te rugăm să alegi tipurile de fișiere care pot fi încărcate de către elevi:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               @checked(in_array("pdf", $filetypes ?? []) || old('accept_pdf_upload'))
                               id="accept_pdf_upload" name="accept_pdf_upload">
                        <label class="form-check-label" for="accept_pdf_upload">
                            Documente PDF (.pdf)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               @checked(in_array("doc", $filetypes) || old('accept_word_upload'))
                               id="accept_word_upload" name="accept_word_upload">
                        <label class="form-check-label" for="accept_word_upload">
                            Documente Word (.doc,.docx,.odt)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               @checked(in_array("png", $filetypes ?? []) || old('accept_image_upload'))
                               id="accept_image_upload" name="accept_image_upload">
                        <label class="form-check-label" for="accept_image_upload">
                            Imagini (.jpg,.png,.bmp,.jpeg)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               @checked(in_array("c", $filetypes) || old('accept_code_upload'))
                               id="accept_code_upload"
                               name="accept_code_upload">
                        <label class="form-check-label" for="accept_code_upload">
                            Sursă de cod (.c,.cpp,.pas,.java,.cs,.m,.kt,.dart,.swift,.js,.ts,.rb,.php)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               @checked(in_array("zip", $filetypes ?? []) || old('accept_archive_upload'))
                               id="accept_archive_upload" name="accept_archive_upload">
                        <label class="form-check-label" for="accept_archive_upload">
                            Arhive (.rar,.zip,.7z,.gz)
                        </label>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">Salvează</button>
            </form>
        </div>
    </div>
@endsection
