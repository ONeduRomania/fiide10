@extends('layouts.app')

@section('content')
    <x-navbar-component class="navbar navbar-expand-md fixed-top navbar-dark bg-royal"/>

    <section class="section-info">
        <div class="container my-5">
            <div class="px-5 py-5">
                <h2 class="text-center font-weight-bold">Contribuitori</h2>
                <p> Toate mulțumirile noastre pentru ajutorul oferit în programarea platformei se îndreaptă spre: </p>
                <p> Radu Vrînceanu - <a href="https://github.com/iRaduS/"> GitHub</a></p>
                <p> Lucian - <a href="https://github.com/luciandex"> GitHub</a></p>
                <br/>
                <p> De asemenea mulțumim și tuturor sponsorilor și partenerilor din proiect: </p>
                <p><a href="https://semimaratongalati.ro"> Semimaraton Galați</a></p>
                <p><a href="https://fabine.eu"> Platforma Fă Bine</a></p>
                <p><a href="https://mabucurdeviata.ro"> Asociația Mă Bucur de Viață</a></p>
            </div>
        </div>
    </section>

    <x-footer-component/>
@endsection
