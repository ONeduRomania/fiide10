<div>
    <nav aria-label="breadcrumb" class="bg-gray">
        <ol class="breadcrumb bg-gray">
            <li class="breadcrumb-item">
                <span class="badge badge-pill badge-royal my-auto">{{ __('BREADCRUMBS') }}</span>
            </li>

            @foreach($uris as $uri)
                <li class="breadcrumb-item">
                    <div class="text-white">{{ ucfirst($uri) }}</div>
                </li>
            @endforeach
        </ol>
    </nav>
</div>
