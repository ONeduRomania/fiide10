<div>
    @if (session('success'))
        <div class="alert" role="alert">
            <button type="button" class="btn btn-royal dismissible" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times"></i></span>
            </button>
            <div class="my-1 text-center">
                <p class="text-white">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert" role="alert">
            <button type="button" class="btn btn-danger dismissible" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times"></i></span>
            </button>
            <div class="my-1 text-center">
                <p class="text-white">
                    <strong>Eroare: </strong> {{ session('error') }}
                </p>
            </div>
        </div>
    @endif
</div>
