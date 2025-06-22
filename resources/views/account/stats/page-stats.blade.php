<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.sites.index') }}">{{ __('Websites') }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('user.site.show', ['code' => $site->code]) }}">{{ $site->label }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('user.site.pages', ['code' => $site->code]) }}">{{ __('Pages') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Page stats') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="fw-bold fs-5 mb-2">
                    <i class="bi bi-graph-up"></i> <span class="fw-normal">{{ __('Page log') }}</span> - {{ $page->title }}
                    <div class="fs-6 fw-normal mt-2"><a target="_blank" href="https://{{ $page->domain }}{{ $page->page }}">{{ $page->domain }}{{ $page->page }}</a></div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Referrer') }}</th>
                            <th scope="col">{{ __('Date') }}</th>
                            <th scope="col">{{ __('Visitor details') }}</th>
                            <th scope="col">{{ __('Performance') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessions as $session)
                            <tr>
                                <th>
                                    @if ($session->referrer)
                                        <span class="fw-normal"><i class="bi bi-box-arrow-right fs-5"></i> <a target="_blank" title="{{ $session->referrer }}"
                                                href="{{ $session->referrer }}">{{ $session->referrer }}</a></span>
                                    @else
                                        <i class="bi bi-check fs-5"></i> {{ __('Direct visit') }}
                                    @endif
                                </th>

                                <th>
                                    <div class="small text-muted mb-1">
                                        <b>{{ $session->time_diff_human }}</b>
                                    </div>
                                </th>

                                <th>
                                    <div class="float-start me-2"><img style="width: 22px; height: 22px;" src="{{ config('app.cdn') }}/assets//img/flags/circle/{{ strtolower($session->visitor->geo_cc) }}.svg" alt="{{ $session->visitor->geo_country }}">
                                    </div>
                                    {{ $session->visitor->geo_city }}, {{ $session->visitor->geo_country }} <i class="bi bi-dot"></i> <span class="text-muted small fw-normal">{{ $session->visitor->ip }}</span>

                                    <div class="clearfix"></div>

                                    <div class="fw-normal">
                                        @if ($session->visitor->device_type == 'm')
                                            <i class="bi bi-phone" title="{{ __('Mobile device') }}"></i>
                                            @if (($session->visitor->device_family || $session->visitor->device_model) && !($session->visitor->device_family == 'Unknown' || $session->visitor->device_family == 'K'))
                                                {{ $session->visitor->device_family . ' ' . $session->visitor->device_model }}
                                            @else
                                                {{ __('Mobile device') }}
                                            @endif
                                        @elseif($session->visitor->device_type == 'd')
                                            <i class="bi bi-display" title="{{ __('Desktop PC') }}"></i> {{ __('Desktop PC') }}
                                        @elseif($session->visitor->device_type == 't')
                                            <i class="bi bi-tablet-landscape" title="{{ __('"Tablet') }}"></i> {{ __('"Tablet') }}
                                        @elseif($session->visitor->device_type == 'b')
                                            <i class="bi bi-search" title="{{ __('Bot / Crawler') }}"></i> {{ __('Bot / Crawler') }}
                                        @endif

                                        <i class="bi bi-dot"></i> {{ $session->visitor->screen_size }}px

                                        <div class="clearfix"></div>

                                        @if ($session->visitor->browser_family == 'Chrome')
                                            <i class="bi bi-browser-chrome" title="Chrome"></i> Chrome
                                        @elseif($session->visitor->browser_family == 'Safari')
                                            <i class="bi bi-browser-safari" title="Safari"></i> Safari
                                        @elseif($session->visitor->browser_family == 'Microsoft Edge')
                                            <i class="bi bi-browser-edge" title="Microsoft Edge"></i> Microsoft Edge
                                        @elseif($session->visitor->browser_family == 'Firefox')
                                            <i class="bi bi-browser-firefox" title="Firefox"></i> Firefox
                                        @elseif ($session->visitor->browser_family == 'Chrome Mobile')
                                            <i class="bi bi-browser-chrome" title="Chrome Mobile"></i> Chrome Mobile
                                        @elseif ($session->visitor->browser_family == 'HeadlessChrome')
                                            <i class="bi bi-browser-chrome" title="HeadlessChrome"></i> HeadlessChrome
                                        @elseif ($session->visitor->browser_family == 'Mobile Safari')
                                            <i class="bi bi-browser-safari" title="Mobile Safari"></i> Mobile Safari
                                        @else
                                            <i class="bi bi-window" title="{{ $session->visitor->browser_family }}"></i> {{ $session->visitor->browser_family }}
                                        @endif

                                        <i class="bi bi-dot"></i> {{ $session->visitor->platform_name }}
                                    </div>
                                </th>

                                <th>
                                    <div class="fw-normal small text-muted mb-2">
                                        @if ($session->seconds_min < 10)
                                            <i class="bi bi-circle-fill text-danger"></i> <b>{{ __('Time on page') }}:</b> {{ __('under 10 seconds') }}
                                        @elseif($session->seconds_min >= 10 && $session->seconds_min < 30)
                                            <i class="bi bi-circle-fill text-warning"></i> <b>{{ __('Time on page') }}:</b> {{ __('10 to 30 seconds') }}
                                        @elseif($session->seconds_min >= 30 && $session->seconds_min < 60)
                                            <i class="bi bi-circle-fill text-warning"></i> <b>{{ __('Time on page') }}:</b> {{ __('30 to 60 seconds') }}
                                        @elseif($session->seconds_min >= 60 && $session->seconds_min < 120)
                                            <i class="bi bi-circle-fill text-info"></i> <b>{{ __('Time on page') }}:</b> {{ __('1 to 2 minutes') }}
                                        @elseif($session->seconds_min >= 120 && $session->seconds_min < 180)
                                            <i class="bi bi-circle-fill text-success"></i> <b>{{ __('Time on page') }}:</b> {{ __('2 to 3 minutes') }}
                                        @elseif($session->seconds_min >= 180 && $session->seconds_min < 300)
                                            <i class="bi bi-circle-fill text-success"></i> <b>{{ __('Time on page') }}:</b> {{ __('3 to 5 minutes') }}
                                        @elseif($session->seconds_min >= 300)
                                            <i class="bi bi-circle-fill text-success"></i> <b>{{ __('Time on page') }}:</b> {{ __('Over 5 minutes') }}
                                        @else
                                            -
                                        @endif
                                    </div>                                    

                                    <div class="mb-1"></div>

                                    <div class="fw-normal small text-muted mb-2">                                                                         
                                        @if ($session->scroll_percent < 25)
                                            <i class="bi bi-circle-fill text-danger"></i> <b>{{ __('Page scroll') }}: {{ $session->scroll_percent }}%</b> 
                                        @elseif($session->scroll_percent >= 25 && $session->scroll_percent < 50)
                                            <i class="bi bi-circle-fill text-warning"></i> <b>{{ __('Page scroll') }}:</b> {{ $session->scroll_percent }}%
                                        @elseif($session->scroll_percent >= 50 && $session->scroll_percent < 75)
                                            <i class="bi bi-circle-fill text-info"></i> <b>{{ __('Page scroll') }}:</b> {{ $session->scroll_percent }}%
                                        @elseif($session->scroll_percent >= 75)
                                            <i class="bi bi-circle-fill text-success"></i> <b>{{ __('Page scroll') }}:</b> {{ $session->scroll_percent }}%
                                        @else
                                            -
                                        @endif
                                    </div>
                                </th>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $sessions->links() }}
            </div>
            <!-- end card-body -->

        </div>

    </div>

</div>
