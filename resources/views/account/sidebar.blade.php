<!-- Left Sidebar -->
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">

        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <img src="{{ asset('assets//img/logo-backend.png') }}" class="img-fluid" alt="{{ config('app.name') }}">
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle fs-3 text-white"></i></a>
                </div>
            </div>
        </div>


        <div class="sidebar-menu">
            <ul class="menu">

                <li class="sidebar-item @if (($active_menu ?? null) == 'sites') active @endif">
                    <a href="{{ route('sites.index') }}" class='sidebar-link'>
                        <i class="bi bi-gear"></i>
                        <span>{{ __('Manage Websites') }}</span>
                    </a>
                </li>

                @include('account.sidebar-sites')

                @if ($site ?? null)
                    <li class="sidebar-item @if (($active_menu ?? null) == 'overview') active @endif">
                        <a href="{{ route('site.show', ['code' => $site->code]) }}" class='sidebar-link'>
                            <i class="bi bi-house"></i>
                            <span>{{ __('Overview') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-item @if (($active_menu ?? null) == 'reports') active @endif">
                        <a href="{{ route('site.reports', ['code' => $site->code]) }}" class='sidebar-link'>
                            <i class="bi bi-graph-up-arrow"></i>
                            <span>{{ __('Reports') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-item @if (($active_menu ?? null) == 'visitors') active @endif">
                        <a href="{{ route('site.visitors', ['code' => $site->code]) }}" class='sidebar-link'>
                            <i class="bi bi-person-workspace"></i>
                            <span>{{ __('Visitors') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-item @if (($active_menu ?? null) == 'pages') active @endif">
                        <a href="{{ route('site.pages', ['code' => $site->code]) }}" class='sidebar-link'>
                            <i class="bi bi-file-text"></i>
                            <span>{{ __('Pages') }}</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
<!-- End Sidebar -->
