@extends('layouts.dashboard')

@section('content')
    <div class="section-info d-flex align-items-center my-5">
        <div class="container-fluid">
            <x-alert></x-alert>
            <div class="container">
                <h5> Tema: {{ $homework->name }}</h5>
                <p class="text-muted">De aici poți trimite tema ta.</p>

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <form method="POST" class="dropzone" id="homework-submit-form" action="{{ route('homework.submit_post', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id, 'homework' => $homework->id]) }}">
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
