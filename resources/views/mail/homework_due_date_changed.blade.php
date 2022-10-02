@extends('mail.base')
@section('preheader')
    S-a schimbat data limită pentru tema {{ $homework->name }}!
@endsection
@section('content')
    <img src="{{ $message->embed(public_path("images/files.svg"))  }}" alt="Ilustrație temă"/>
    <br/>
    <p>Salut,</p>
    <p>Data limită pentru tema <strong>{{ $homework->name }}</strong> de la materia
        <strong>{{ $schoolSubject->name }}</strong>. Acum ai
        timp să o trimiți până la <strong>{{ (new DateTime($homework->due_date))->format("d-m-Y, H:i") }}</strong>.</p>

    @include('mail.button', ['url' => route('homework.submit_get', ['school' => $schoolSubject->school_id, 'classroom' => $homework->class_id, 'subject' => $schoolSubject, 'homework' => $homework]), 'cta' => 'Trimite tema'])
    <p>Spor la lucru!</p>
@endsection
