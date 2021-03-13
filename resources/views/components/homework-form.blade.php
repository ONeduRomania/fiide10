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

        <input id="due_date" type="date"
               class="form-control @error('due_date') is-invalid @enderror" name="due_date"
               value="{{ $homework != null ? $homework->due_date : old('due_date') }}"
               placeholder="{{ __('Enter the due date...') }}"
               required>
        @error('due_date')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
