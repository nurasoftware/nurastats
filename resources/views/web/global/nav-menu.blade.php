<div class="row">
    <div class="col-12">
        <div class="float-end">
            <ul class="d-flex ms-auto mb-0 mb-lg-0 align-items-center">

                <div class="me-3">
                    <a href="https://business.clevada.com" title="{{ __('Clevada Products for Business, Teams, Collaboration, and Website Owners') }}">
                        {{-- <i class="bi bi-grid-fill fs-3 text-info"></i> --}}
                        <img src="{{ config('app.cdn') }}/assets/img/segmentation.png" alt="Clevada products" class="img-fluid me-1" /> {{ __('For business') }}
                    </a>
                </div>

                <div class="me-3">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        {{-- <i class="bi bi-grid-fill fs-3 text-info"></i> --}}
                        <img src="{{ config('app.cdn') }}/assets/img/products-grid-icon-30.png" alt="Clevada products" class="img-fluid me-1" /> {{ __('For anyone') }}
                    </a>
                </div>

                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-img d-flex">
                                <div class="avatar avatar-md fw-bold">
                                    <img src="{{ avatar(Auth::user()->avatar) }}" alt="Avatar" class="img-fluid me-1" /> {{ __('My account') }}
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuUser">
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
                    </ul>
                </div>
            </ul>
        </div>
    </div>
</div>
