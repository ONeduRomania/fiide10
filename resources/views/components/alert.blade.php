<div>
    @if (session('success'))
        <div class="alert alert-dismissible fade show" role="alert">
            <p>{{ session('success') }}</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="{{__('Închide alerta')}}">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert" role="alert">
            <div class="alert alert-dismissible fade show" role="alert">
                <p>{{ session('error') }}</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="{{__('Închide alerta')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
</div>
