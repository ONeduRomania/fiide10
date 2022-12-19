@extends('dashboard.admin.schools.show')

@section('pageName')
    Tema: {{ $homework->name }}
@endsection

@section('subcontent')
    <div class="section-info">
        <div class="container-fluid">
            <div class="col">
                <form
                    action="{{ route('homework.submit_post', ['school' => $school->id, 'class' => $class->id, 'homework' => $homework->id]) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="file" class="custom-file-input" id="chooseFile" multiple>
                        <label class="custom-file-label" for="chooseFile">Selectează un fișier</label>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                        Trimite
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
