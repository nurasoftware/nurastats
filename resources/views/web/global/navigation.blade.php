<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white static-top">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="{{ config('app.cdn') }}/assets/img/logo.png" alt="{{ config('app.name') }}" title="{{ config('app.name') }}"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">

                <div class="float-end">
                    <div class="d-flex ms-auto mb-0 mb-lg-0 align-items-center">

                        <div class="dropdown me-3">
                            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex">
                                    <div class="fw-bold">
                                        <img src="{{ config('app.cdn') }}/assets/img/cms/analytics/menu-icon-32x32.png" alt="Clevada Analytics" class="img-fluid me-0" /> {{ __('Analytics') }} <i class="bi bi-chevron-down"></i>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuUser">                                
                                <li>
                                    <a class="dropdown-item" href="https://analytics.clevada.com"><i class="icon-mid bi bi-clipboard-check me-2"></i> {{ __('Clevada Analytics Features') }}</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://sites.clevada.com" target="_blank"><i class="icon-mid bi bi-question-circle me-2"></i> {{ __('Help and Integration') }}</a>
                                </li>
                               
                                <li>
                                    <a class="dropdown-item" href="https://sites.clevada.com" target="_blank"><i class="icon-mid bi bi-arrow-left-right me-2"></i> {{ __('Comparisons') }}</a>
                                </li>
                            </div>
                        </div>

                        <div class="dropdown me-3">
                            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex">
                                    <div class="fw-bold">
                                        <img src="{{ config('app.cdn') }}/assets/img/icon-products-grey.png" alt="Clevada products" class="img-fluid me-0" /> {{ __('All products') }}
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuUser">
                                <li>
                                    <div class="dropdown-header fw-bold fs-6 text-clamp-1">{{ __('CLEVADA FOR BUSINESS') }}</div>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://analytics.clevada.com"><i class="icon-mid bi bi-graph-up-arrow me-2"></i> {{ __('Analytics') }}</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://sites.clevada.com" target="_blank"><i class="icon-mid bi bi-globe me-2"></i> {{ __('Websites') }}</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://workspace.clevada.com" target="_blank"><i class="icon-mid bi bi-person-workspace me-2"></i> {{ __('Workspaces') }}</a>
                                </li>


                                <hr class="dropdown-divider">

                                <li>
                                    <div class="dropdown-header fw-bold fs-6 text-clamp-1">{{ __('CLEVADA FOR ANYONE') }}</div>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://mail.clevada.com" target="_blank"><i class="icon-mid bi bi-envelope me-2"></i> {{ __('Email') }}</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://drive.clevada.com" target="_blank"><i class="icon-mid bi bi-hdd-rack me-2"></i> {{ __('Drive (Storage)') }}</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://bookmarks.clevada.com" target="_blank"><i class="icon-mid bi bi-bookmarks me-2"></i> {{ __('Bookmarks') }}</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://vault.clevada.com" target="_blank"><i class="icon-mid bi bi-key me-2"></i> {{ __('Vault') }}</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://notes.clevada.com" target="_blank"><i class="icon-mid bi bi-stickies me-2"></i> {{ __('Notes') }}</a>
                                </li>

                                <hr class="dropdown-divider">

                                <li>
                                    <div class="dropdown-header fw-bold fs-6 text-clamp-1">{{ __('PORTAL') }}</div>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://bookmarks.clevada.com" target="_blank"><i class="icon-mid bi bi-search me-2"></i> {{ __('Search') }}</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://clevada.com/feed" target="_blank"><i class="icon-mid bi bi-people me-2"></i> {{ __('Social Network') }}</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://maps.clevada.com" target="_blank"><i class="icon-mid bi bi-pin-map me-2"></i> {{ __('Maps') }}</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="https://weather.clevada.com" target="_blank"><i class="icon-mid bi bi-cloud-sun me-2"></i> {{ __('Weather') }}</a>
                                </li>

                            </div>
                        </div>


                        @if (Auth::user())
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-img d-flex">
                                            <div class="fw-bold">
                                                <img src="{{ avatar(Auth::user()->avatar ?? null) }}" alt="Avatar" class="img-fluid me-1" /> {{ __('My account') }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuUser">
                                    <li>
                                        <div class="dropdown-header fw-bold fs-6 text-clamp-1">{{ Auth::user()->name }}</div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="https://account.clevada.com"><i class="icon-mid bi bi-person me-2"></i> {{ __('My Clevada account') }}</a>
                                    </li>

                                    <hr class="dropdown-divider">

                                    <li>
                                        <a class="dropdown-item" href="https://mail.clevada.com" target="_blank"><i class="icon-mid bi bi-envelope me-2"></i> {{ __('Mail') }}</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="https://bookmarks.clevada.com" target="_blank"><i class="icon-mid bi bi-envelope me-2"></i> {{ __('Bookmarke') }}</a>
                                    </li>

                                    @if ((Auth::user()->role ?? null) == 'admin')
                                        <li>
                                            <a class="dropdown-item" target="_blank" href="https://app.clevada.com"><i class="icon-mid bi bi-box-arrow-up-right me-2"></i>
                                                {{ __('My Clevada account') }}</a>
                                        </li>
                                        <li>
                                    @endif
                                    <hr class="dropdown-divider">

                                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="icon-mid bi bi-box-arrow-left me-2"></i> {{ __('Logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </div>
                            </div>
                        @else
                            <a href="#">
                                <div class="user-menu d-flex">
                                    <div class="user-img d-flex">
                                        <div class="avatar avatar-md fw-bold">
                                            <img src="{{ avatar(Auth::user()->avatar ?? null) }}" alt="Avatar" class="img-fluid me-1" /> {{ __('My account') }}
                                        </div>
                                    </div>
                                </div>
                            </a>

                        @endif

                    </div>
                </div>

            </ul>
        </div>
    </div>
</nav>
