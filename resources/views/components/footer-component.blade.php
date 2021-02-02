<footer class="footer d-flex align-items-center">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12 col-lg-3 text-center my-3">
               <img loading="lazy" class="aligncenter wp-image-55" src="https://onedu.ro/wp-content/uploads/2021/02/Platforma-Fii-de-10-09.png" alt="" width="80" height="80">
                <p class="text-white-50">
                    {!!  __('&copy; 2021 Comunitatea ONedu România') !!}
                </p>
            </div>
            <div class="col-md-12 col-lg-3 text-center my-3">
                <div class="font-weight-bold text-white-50">{{ __('Legal') }}</div>
                <div class="d-flex flex-column">
                    <a href="{{ route('legal.terms') }}" class="text-decoration-none"><small class="text-white">{{ __('Termenii și condițiile') }}</small></a>
                    <a href="{{ route('legal.privacy') }}" class="text-decoration-none"><small class="text-white">{{ __('Politica de confidențialitate') }}</small></a>
                    <a href="{{ route('legal.rules') }}" class="text-decoration-none"><small class="text-white">{{ __('Contribuitori') }}</small></a>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 text-center my-3">
                <div class="font-weight-bold text-white-50">{{ __('Social') }}</div>
                <div class="d-flex flex-column">
                    <a href="https://onedu.ro" class="text-decoration-none"><small class="text-white">{{ __('Comunitatea ONedu România') }}</small></a>
                    <div class="btn-group" role="group">
                        <a class="btn text-white" href="https://facebook.com/ONeduRomania">Facebook <i class="fab fa-facebook-f"></i></a>
                        <a class="btn text-white" href="https://instagram.com/fiide10.ro">Instagram <i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 text-center my-3">
                <p class="text-white">
                    {{ __('Pagina a fost încărcată în: ') }} {{ round(microtime(true) - LARAVEL_START, 3) }}s
                    <br/>
                    <a class="text-white text-decoration-none" href="">{{ __('Change language to Romanian') }}</a>
                </p>
            </div>
        </div>
    </div>
</footer>
