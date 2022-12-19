@extends('dashboard.admin.schools.show')

@section('pageName')
    {{$class->name}} - {{__('Temă nouă')}}
@endsection

@section('subcontent')
    <div class="container-fluid">
        <div class="col">
            <form method="POST"
                  action="{{ route('homework.store', ['school' => $school->id, 'class' => $class->id]) }}">
                @csrf
                <div class="form-group">
                    <label for="subject" class="text-md-left">Selctează materia:</label>
                    <select id="subject" name="subject"
                            class="form-control @error('subject') is-invalid @enderror" required autofocus>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name" class="text-md-left">Introdu un nume sugestiv pentru temă:</label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}" required autofocus>
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
                           value="{{ old('due_date') }}" placeholder="Introdu data aici..." required>
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
                               @checked(old('accept_pdf_upload'))
                               id="accept_pdf_upload" name="accept_pdf_upload">
                        <label class="form-check-label" for="accept_pdf_upload">
                            Documente PDF (.pdf)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               @checked(old('accept_word_upload'))
                               id="accept_word_upload" name="accept_word_upload">
                        <label class="form-check-label" for="accept_word_upload">
                            Documente Word (.doc,.docx,.odt)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               @checked(old('accept_image_upload'))
                               id="accept_image_upload" name="accept_image_upload">
                        <label class="form-check-label" for="accept_image_upload">
                            Imagini (.jpg,.png,.bmp,.jpeg)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               @checked(old('accept_code_upload'))
                               id="accept_code_upload"
                               name="accept_code_upload">
                        <label class="form-check-label" for="accept_code_upload">
                            Sursă de cod (.c,.cpp,.pas,.java,.cs,.m,.kt,.dart,.swift,.js,.ts,.rb,.php)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               @checked(old('accept_archive_upload'))
                               id="accept_archive_upload" name="accept_archive_upload">
                        <label class="form-check-label" for="accept_archive_upload">
                            Arhive (.rar,.zip,.7z,.gz)
                        </label>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">Adaugă</button>
            </form>
        </div>
    </div>
@endsection
