@extends('layouts.app')

@once
    @push('scripts')
        <script src="{{ mix('js/helpers.js') }}" defer></script>
    @endpush
@endonce

@section('content')
    <x-navbar-component class="navbar navbar-expand-md fixed-top navbar-dark bg-transparent">
        <li class="nav-item">
            <a class="nav-link" href="https://onedu.ro/fiide10/about">Despre platformă</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="#scoala">Ești director?</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="https://onedu.ro/wp-content/uploads/2021/01/acord-parteneriat.docx">Acord de parteneriat</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="https://youtube.com/playlist?list=PLKUQqACKsU5Wukb5myc1iDhMscgKYkKKR">Tutoriale video</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
        </li>
    </x-navbar-component>

    <section class="section-main d-flex align-items-center">
        <div class="container text-center">
               <img loading="lazy" class="aligncenter wp-image-55" src="https://onedu.ro/wp-content/uploads/2020/12/Platforma-Fii-de-10-03.png" alt="" width="300" height="300">
            <br/>
            <a class="mt-2 btn btn-royal @auth d-none @endauth" href="{{ route('login') }}">Loghează-te acum!</a>   
        </div>
    </section>

    <div data-spy="scroll" data-target="#navbarMain" data-offset="0">
        <section class="section-info d-flex align-items-center" id="despre">
            <div class="container my-5">
                <h2 class="text-center mb-3 font-weight-bold">{{ __('Despre proiectul Fii de 10!') }}</h2>

                <div class="row justify-content-center text-center my-5">
                    <div class="col-md-12 col-lg-4 my-3">
                        <img src="{{ asset('images/chart.svg') }}" height="100" />
                        <h5 class="font-weight-bold mt-1">{{ __('Performanțe școlare') }}</h5>
                        <small class="text-muted">
                            Prin modulele platformei, elevul își poate spori performanța și vizualiza în timp real rezultatele.
                        </small>
                    </div>
                    <div class="col-md-12 col-lg-4 my-3">
                        <img src="{{ asset('images/files.svg') }}" height="100" />
                        <h5 class="font-weight-bold mt-1">Totul la îndemână</h5>
                        <small class="text-muted">
                           Platforma se adaptează perfect pe dispozitivele mobile, îmbunătățind procesul educațional din clasă.
                        </small>
                    </div>
                    <div class="col-md-12 col-lg-4 my-3">
                        <img src="{{ asset('images/tasks.svg') }}" height="100" />
                        <h5 class="font-weight-bold mt-1">Termene limită</h5>
                        <small class="text-muted">
                           Cu platforma Fii de 10! termenele limită nu mai sunt o problemă. Primești notificare când trebuie să trimiți tema sau raportul.
                        </small>
                    </div>     <a class="mt-2 btn btn-royal @auth d-none @endauth" href="https://10.onedu.ro">Află mai multe</a>
                </div>
            </div>
       
        </section>

        <section class="section-usage d-flex align-items-center text-center" id="scoala">
            <div class="container section-text my-5 w-50">
                <h3 class="text-white font-weight-bold mb-3">Adu școala ta pe platformă!</h3>
                <p class="text-white-50">
                    Suntem transparenți cu privire la toate datele utilizate și cum facem lucrurile. Ne dorim să fim un sprijin real pentru profesori și elevi, tocmai de aceea ar trebui să te alături și tu! Numai prin utilizarea platformei în mai multe școli putem să facem lucrurile să devină realitate. Totul gratuit!
                </p>
            <a class="mt-2 btn btn-royal @auth d-none @endauth" href="{{ route('register') }}">Creează-ți cont acum!</a> 
            </div>
        </section>

        <section class="section-about d-flex align-items-center" id="contact">
            <div class="container section-text my-5 w-50">
                <h3 class="font-weight-bold mb-3 text-center">Intră în contact!</h3>
                <div class="row">
                    <div class="col-md-12 col-lg-6 text-center">
                        <h5 class="font-weight-bold">Contactează-ne</h5>
                        <p class="text-muted">
                           Ne poți scrie la fiide10@onedu.ro sau poți completa un formular de contact. 
                        </p>
                        <a class="mt-2 btn btn-royal @auth d-none @endauth" href="https://onedu.ro/fiide10/contact">Completează formularul</a>
                    </div>
                    <div class="col-md-12 col-lg-6 text-center">
                        <img src="{{ asset('images/programming.svg') }}" height="100" />
                    </div>
                </div>
            </div>
        </section>
    </div>

    <x-footer-component/>
@endsection
