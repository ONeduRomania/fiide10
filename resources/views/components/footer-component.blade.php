<footer class="footer d-flex align-items-center">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12 col-lg-3 text-center my-3">
                <h3 class="text-white"><strong>FiiDe10</strong>.EduManager</h3>
                <p class="text-white-50">
                    {!!  __('&copy; 2020 to Vrinceanu Radu-Tudor. All rights reserved for the content.') !!}
                </p>
            </div>
            <div class="col-md-12 col-lg-3 text-center my-3">
                <div class="font-weight-bold text-white-50">{{ __('Legal & terms URLs') }}</div>
                <div class="d-flex flex-column">
                    <a href="{{ route('legal.terms') }}" class="text-decoration-none"><small class="text-white">{{ __('Terms and conditions') }}</small></a>
                    <a href="{{ route('legal.privacy') }}" class="text-decoration-none"><small class="text-white">{{ __('Privacy policy') }}</small></a>
                    <a href="{{ route('legal.rules') }}" class="text-decoration-none"><small class="text-white">{{ __('Internal regulation') }}</small></a>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 text-center my-3">
                <div class="font-weight-bold text-white-50">{{ __('Parteners & Social URLs') }}</div>
                <div class="d-flex flex-column">
                    <a href="https://onedu.ro" class="text-decoration-none"><small class="text-white">{{ __('ONedu Romania Community') }}</small></a>
                    <a href="https://web365.ro" class="text-decoration-none"><small class="text-white">{{ __('web365 Hosting Services') }}</small></a>
                    <div class="btn-group" role="group">
                        <a class="btn text-white" href="https://facebook.com">Facebook <i class="fab fa-facebook-f"></i></a>
                        <a class="btn text-white" href="https://instagram.com">Instagram <i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 text-center my-3">
                <div class="font-weight-bold text-white-50">{{ __('Details') }}</div>
                <p class="text-white">
                    {{ __('Page was rendered in: ') }} {{ round(microtime(true) - LARAVEL_START, 3) }}s
                    <br/>
                    <a class="text-white text-decoration-none" href="">{{ __('Change language to Romanian') }}</a>
                </p>
            </div>
        </div>
    </div>
</footer>
