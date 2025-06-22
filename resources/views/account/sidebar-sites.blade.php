<li class="sidebar-item drive-sidebar-upload-btn mb-4">
    <div class="dropdown">
        <button class="btn btn-sidebar-products dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ $site->label ?? __('Active websites') }}
        </button>
        <ul class="dropdown-menu w-100">
            @foreach ($sidebar_websites as $sidebar_website)
                <li><a class="dropdown-item" href="{{ route('site.show', ['code' => $sidebar_website->code]) }}"><span>{{ $sidebar_website->label }}</span></a></li>
            @endforeach
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{ route('sites.index', ['openmodal' => 1]) }}"><i class="bi bi-plus-circle"></i> <span>{{ __('Add new site') }}</span></a></li>
            <li><a class="dropdown-item" href="{{ route('sites.index') }}"><i class="bi bi-gear"></i> <span>{{ __('Manage sites') }}</span></a></li>
        </ul>
    </div>
</li>
