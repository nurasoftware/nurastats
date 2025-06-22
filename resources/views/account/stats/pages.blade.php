<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('sites.index') }}">{{ __('Websites') }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('site.show', ['code' => $site->code]) }}">{{ $site->label }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Pages') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-12">

        <div class="card">

            @include('account.stats.includes.menu-pages')

            <div class="card-body">

                <div class="fw-bold fs-5 mb-3">{{ __('Last pages sessions') }}</div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Page details') }}</th>
                            <th scope="col">{{ __('Visitor activity') }}</th>
                            <th scope="col">{{ __('Visitor details') }}</th>
                            <th scope="col">{{ __('Stats') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            {{-- dd($page->count_sessions) --}}
                            <tr>
                                <th>
                                    <div class="small mb-2">{{ $page->time_diff_human }}</div>

                                    <a target="_blank" title="{{ $page->page->domain }}/{{ $page->page->page }}" href="https://{{ $page->page->domain }}{{ $page->page->page }}">{{ $page->page->title }}</a>
                                    <div class="small text-muted fw-normal mb-2">
                                        {{ $page->page->domain }}</b>{{ $page->page->page }}

                                        <div class="fw-bold">
                                            @if ($page->referrer)
                                                {{ __('Referrer') }}: {{ $page->referrer }}
                                            @else
                                                {{ __('Direct visit') }}
                                            @endif
                                        </div>
                                    </div>

                                </th>

                                <th>
                                    <div class="fw-normal small text-muted mb-2">
                                        @if ($page->seconds_min < 10)
                                            <i class="bi bi-circle-fill text-danger"></i> <b>{{ __('Time on page') }}:</b> {{ __('under 10 seconds') }}
                                        @elseif($page->seconds_min >= 10 && $page->seconds_min < 30)
                                            <i class="bi bi-circle-fill text-warning"></i> <b>{{ __('Time on page') }}:</b> {{ __('10 to 30 seconds') }}
                                        @elseif($page->seconds_min >= 30 && $page->seconds_min < 60)
                                            <i class="bi bi-circle-fill text-warning"></i> <b>{{ __('Time on page') }}:</b> {{ __('30 to 60 seconds') }}
                                        @elseif($page->seconds_min >= 60 && $page->seconds_min < 120)
                                            <i class="bi bi-circle-fill text-info"></i> <b>{{ __('Time on page') }}:</b> {{ __('1 to 2 minutes') }}
                                        @elseif($page->seconds_min >= 120 && $page->seconds_min < 180)
                                            <i class="bi bi-circle-fill text-success"></i> <b>{{ __('Time on page') }}:</b> {{ __('2 to 3 minutes') }}
                                        @elseif($page->seconds_min >= 180 && $page->seconds_min < 300)
                                            <i class="bi bi-circle-fill text-success"></i> <b>{{ __('Time on page') }}:</b> {{ __('3 to 5 minutes') }}
                                        @elseif($page->seconds_min >= 300)
                                            <i class="bi bi-circle-fill text-success"></i> <b>{{ __('Time on page') }}:</b> {{ __('Over 5 minutes') }}
                                        @else
                                            -
                                        @endif
                                    </div>

                                    <div class="mb-1"></div>

                                    <div class="fw-normal small text-muted mb-2">
                                        @if ($page->scroll_percent < 25)
                                            <i class="bi bi-circle-fill text-danger"></i> <b>{{ __('Page scroll') }}:</b>
                                        < 25% @elseif($page->scroll_percent >= 25 && $page->scroll_percent < 50) <i class="bi bi-circle-fill text-warning"></i> <b>{{ __('Page scroll') }}:</b> 25 to 50%
                                            @elseif($page->scroll_percent >= 50 && $page->scroll_percent < 75)
                                                <i class="bi bi-circle-fill text-info"></i> <b>{{ __('Page scroll') }}:</b> 50 to 75%
                                            @elseif($page->scroll_percent >= 75)
                                                <i class="bi bi-circle-fill text-success"></i> <b>{{ __('Page scroll') }}:</b> > 75%
                                            @else
                                                -
                                        @endif
                                    </div>
                                </th>

                                <th>
                                    <div class="float-start me-2"><img style="width: 22px; height: 22px;" src="{{ config('app.cdn') }}/assets//img/flags/circle/{{ strtolower($page->visitor->geo_cc) }}.svg" alt="{{ $page->visitor->geo_country }}">
                                    </div>
                                    {{ $page->visitor->geo_city }}, {{ $page->visitor->geo_country }} <i class="bi bi-dot"></i> <span class="text-muted small fw-normal">{{ $page->visitor->ip }}</span>

                                    <div class="clearfix"></div>

                                    <div class="fw-normal">
                                        @if ($page->visitor->device_type == 'm')
                                            <i class="bi bi-phone" title="{{ __('Mobile device') }}"></i>
                                            @if (($page->visitor->device_family || $page->visitor->device_model) && !($page->visitor->device_family == 'Unknown' || $page->visitor->device_family == 'K'))
                                                {{ $page->visitor->device_family . ' ' . $page->visitor->device_model }}
                                            @else
                                                {{ __('Mobile device') }}
                                            @endif
                                        @elseif($page->visitor->device_type == 'd')
                                            <i class="bi bi-display" title="{{ __('Desktop PC') }}"></i> {{ __('Desktop PC') }}
                                        @elseif($page->visitor->device_type == 't')
                                            <i class="bi bi-tablet-landscape" title="{{ __('"Tablet') }}"></i> {{ __('"Tablet') }}
                                        @elseif($page->visitor->device_type == 'b')
                                            <i class="bi bi-search" title="{{ __('Bot / Crawler') }}"></i> {{ __('Bot / Crawler') }}
                                        @endif

                                        <i class="bi bi-dot"></i> {{ $page->visitor->screen_size }}px

                                        <div class="clearfix"></div>

                                        @if ($page->visitor->browser_family == 'Chrome')
                                            <i class="bi bi-browser-chrome" title="Chrome"></i> Chrome
                                        @elseif($page->visitor->browser_family == 'Safari')
                                            <i class="bi bi-browser-safari" title="Safari"></i> Safari
                                        @elseif($page->visitor->browser_family == 'Microsoft Edge')
                                            <i class="bi bi-browser-edge" title="Microsoft Edge"></i> Microsoft Edge
                                        @elseif($page->visitor->browser_family == 'Firefox')
                                            <i class="bi bi-browser-firefox" title="Firefox"></i> Firefox
                                        @elseif ($page->visitor->browser_family == 'Chrome Mobile')
                                            <i class="bi bi-browser-chrome" title="Chrome Mobile"></i> Chrome Mobile
                                        @elseif ($page->visitor->browser_family == 'HeadlessChrome')
                                            <i class="bi bi-browser-chrome" title="HeadlessChrome"></i> HeadlessChrome
                                        @elseif ($page->visitor->browser_family == 'Mobile Safari')
                                            <i class="bi bi-browser-safari" title="Mobile Safari"></i> Mobile Safari
                                        @else
                                            <i class="bi bi-window" title="{{ $page->visitor->browser_family }}"></i> {{ $page->visitor->browser_family }}
                                        @endif

                                        <i class="bi bi-dot"></i> {{ $page->visitor->platform_name }}
                                    </div>
                                </th>

                                <th>
                                    <i class="bi bi-graph-up"></i> <a href="{{ route('site.page_stats', ['code' => $site->code, 'hash' => $page->page->hash]) }}">{{ __('Page history') }}</a>
                                </th>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $pages->links() }}
            </div>
            <!-- end card-body -->

        </div>

    </div>

</div>
