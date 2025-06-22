<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('sites.index') }}">{{ __('Websites') }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('site.show', ['code' => $site->code]) }}">{{ $site->label }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Visitors') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="fw-bold fs-5 mb-3">{{ __('Last visitors') }}</div>

                @foreach ($visitors as $recent_visit)
                    <div class="float-end ms-3 fs-2 text-secondary">
                        @if ($recent_visit->browser_family == 'Chrome')
                            <i class="bi bi-browser-chrome" title="Chrome"></i>
                        @elseif($recent_visit->browser_family == 'Safari')
                            <i class="bi bi-browser-safari" title="Safari"></i>
                        @elseif($recent_visit->browser_family == 'Microsoft Edge')
                            <i class="bi bi-browser-edge" title="Microsoft Edge"></i>
                        @elseif($recent_visit->browser_family == 'Firefox')
                            <i class="bi bi-browser-firefox" title="Firefox"></i>
                        @elseif ($recent_visit->browser_family == 'Chrome Mobile')
                            <i class="bi bi-browser-chrome" title="Chrome Mobile"></i>
                        @elseif ($recent_visit->browser_family == 'HeadlessChrome')
                            <i class="bi bi-browser-chrome" title="HeadlessChrome"></i>
                        @elseif ($recent_visit->browser_family == 'Mobile Safari')
                            <i class="bi bi-browser-safari" title="Mobile Safari"></i>
                        @else
                            <i class="bi bi-window" title="{{ $recent_visit->browser_family }}"></i>
                        @endif
                    </div>

                    <div class="float-end ms-3 fs-2 text-secondary">
                        @if ($recent_visit->platform_family == 'Android')
                            <i class="bi bi-android2" title="Android"></i>
                        @elseif($recent_visit->platform_family == 'Windows')
                            <i class="bi bi-windows" title="Windows"></i>
                        @elseif($recent_visit->platform_family == 'Windows Mobile')
                            <i class="bi bi-windows" title="Windows Mobile"></i>
                        @elseif($recent_visit->platform_family == 'Mac')
                            <i class="bi bi-apple" title="Mac"></i>
                        @elseif($recent_visit->platform_family == 'iOS')
                            <i class="bi bi-apple" title="iOS"></i>
                        @elseif($recent_visit->platform_family == 'Linux')
                            <i class="bi bi-ubuntu" title="Linux"></i>
                        @elseif($recent_visit->platform_family == 'GNU/Linux')
                            <i class="bi bi-ubuntu" title="GNU/Linux"></i>
                        @endif
                    </div>

                    <div class="float-end ms-2 fs-2 text-secondary">
                        @if ($recent_visit->device_type == 'm')
                            <i class="bi bi-phone" title="Mobile device"></i>
                        @elseif($recent_visit->device_type == 'd')
                            <i class="bi bi-display" title="Desktop PC"></i>
                        @elseif($recent_visit->device_type == 't')
                            <i class="bi bi-tablet-landscape" title="Tablet"></i>
                        @elseif($recent_visit->device_type == 'b')
                            <i class="bi bi-search" title="Bot / Crawler"></i>
                        @endif
                    </div>

                    <div class="fw-bold">{{ $recent_visit->time_diff_human }}
                        <span class="fw-normal text-muted small">
                            {{ date('M d, H:i', strtotime($recent_visit->created_at)) }}
                        </span>
                    </div>


                    <div class="float-start me-2"><img style="width: 22px; height: 22px;" src="{{ config('app.cdn') }}/assets//img/flags/circle/{{ strtolower($recent_visit->geo_cc) }}.svg" alt="{{ $recent_visit->geo_country }}"> </div>
                    {{ $recent_visit->geo_city }}, {{ $recent_visit->geo_country }} <i class="bi bi-dot"></i> <span class="text-muted small fw-normal">{{ $recent_visit->ip }}</span>

                    <div class="clearfix"></div>
                    @foreach ($recent_visit->last_5_sessions as $last_session)
                        @if (!$loop->first)
                            <i class="bi bi-arrow-return-right"></i>
                            <span class="text-muted small fw-bold"> {{ date('M d Y, H:i', $last_session->first) }} </span>
                        @endif
                        <a target="_blank" title="{{ $last_session->page->domain }}/{{ $last_session->page->page }}"
                            href="https://{{ $last_session->page->domain }}{{ $last_session->page->page }}"><b>{{ $last_session->page->domain }}</b> /
                            {{ $last_session->page->title }}</a>
                        <div class="small text-muted mb-2">
                            @if ($last_session->referrer)
                                {{ __('Referrer') }}: {{ $last_session->referrer }}
                            @else
                                {{ __('Direct visit') }}
                            @endif
                            |
                            {{ __('Scroll: ') }}: {{ $last_session->scroll_percent }}
                        </div>
                    @endforeach

                    @if ($recent_visit->sessions_count > 3)
                        {{ __() }}
                    @endif

                    <hr>
                @endforeach

                {{ $visitors->links() }}
            </div>
            <!-- end card-body -->

        </div>

    </div>

</div>
