<div>
    <div class="form-group">
        <label for="name" class="text-md-left">{{ __('Homework name') }}</label>

        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
               name="name" value="{{ $homework != null ? $homework->name : old('name') }}"
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

        <input id="due_date" type="datetime-local"
               class="form-control @error('due_date') is-invalid @enderror" name="due_date"
               value="{{ $homework != null ? (new DateTime($homework->due_date))->format("Y-m-d\TH:i") : old('due_date') }}"
               placeholder="{{ __('Enter the due date...') }}"
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
            {{-- The long checked value verifies whether the filetypes array contains a value this checkbox should have. --}}
            <input class="form-check-input" type="checkbox"
                   @if(($homework != null && $homework->filetypes != null && in_array("pdf", json_decode($homework->filetypes, true))) || old('accept_pdf_upload'))
                   checked
                   @endif
                   id="accept_pdf_upload" name="accept_pdf_upload">
            <label class="form-check-label" for="accept_pdf_upload">
                Documente PDF (.pdf)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox"
                   @if(($homework != null && $homework->filetypes != null && in_array("doc", json_decode($homework->filetypes, true))) || old('accept_word_upload'))
                   checked
                   @endif
                   id="accept_word_upload" name="accept_word_upload">
            <label class="form-check-label" for="accept_word_upload">
                Documente Word (.doc,.docx,.odt)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox"
                   @if(($homework != null && $homework->filetypes != null && in_array("png", json_decode($homework->filetypes, true))) || old('accept_image_upload'))
                   checked
                   @endif
                   id="accept_image_upload" name="accept_image_upload">
            <label class="form-check-label" for="accept_image_upload">
                Imagini (.jpg,.png,.bmp,.jpeg)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox"
                   @if(($homework != null && $homework->filetypes != null && in_array("c", json_decode($homework->filetypes, true))) || old('accept_code_upload'))
                   checked
                   @endif
                   id="accept_code_upload" name="accept_code_upload">
            <label class="form-check-label" for="accept_code_upload">
                Sursă de cod (.c,.cpp,.pas,.java,.cs,.m,.kt,.dart,.swift,.js,.ts,.rb,.php)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox"
                   @if(($homework != null && $homework->filetypes != null && in_array("zip", json_decode($homework->filetypes, true))) || old('accept_archive_upload'))
                   checked
                   @endif
                   id="accept_archive_upload" name="accept_archive_upload">
            <label class="form-check-label" for="accept_archive_upload">
                Arhive (.rar,.zip,.7z,.gz)
            </label>
        </div>
    </div>
</div>
