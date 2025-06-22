<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{--
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Date', 'Visitors', 'Views'],
            @foreach ($stats_traffic as $stats_day)
                ["{{ date_format(date_create($stats_day->day), 'd M') }}", {{ $stats_day->visitors }}, {{ $stats_day->views }}],
            @endforeach
        ]);

        var options = {
            chart: {
                //title: 'Traffic',                
            }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>
--}}

<div class="float-end ms-2">
    <a class="btn btn-light btn-sm btn-gear text-white" href="{{ route('site.show', ['code' => $site->code]) }}"><i class="bi bi-arrow-repeat"></i> {{ __('Reload') }}</a>
    <a class="btn btn-light btn-sm btn-gear text-white ms-2" href="{{ route('site.config', ['code' => $site->code]) }}"><i class="bi bi-gear"></i> {{ __('Settings') }}</a>
</div>

<div class="page-title">
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('sites.index') }}">{{ __('Websites') }}</a></li>
            <li class="breadcrumb-item active">{{ $site->label }}</li>
        </ol>
    </nav>
</div>


<div class="row mb-3">

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box bg-white rounded border border-2 border-secondary">
            <i class="bi bi-arrow-counterclockwise float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-1 fw-bold">{{ __('Today') }}</div>
            <div class="text-muted mb-2 small">{{ date('d M Y', strtotime(date('Y-m-d'))) }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">{{ $stats_today_visitors ?? '-' }} {{ __('visitors') }} <i class="bi bi-dot"></i> {{ $stats_today_views ?? '-' }} {{ __('views') }}</div>
            <a class="btn btn-light" href="{{ route('site.reports', ['code' => $site->code, 'range' => $date_today . '_' . $date_today]) }}">{{ __('View report') }}</a>

        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box bg-white rounded border border-2 border-secondary">
            <i class="bi bi-clock-history float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-1 fw-bold">{{ __('Yesterday') }}</div>
            <div class="text-muted mb-2 small">{{ date('d M Y', strtotime('-1 days')) }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">{{ $stats_yesterday_visitors ?? '-' }} {{ __('visitors') }} <i class="bi bi-dot"></i> {{ $stats_yesterday_views ?? '-' }} {{ __('views') }}</div>
            <a class="btn btn-light" href="{{ route('site.reports', ['code' => $site->code, 'range' => $date_yesterday . '_' . $date_yesterday]) }}">{{ __('View report') }}</a>

        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box bg-white rounded border border-2 border-secondary">
            <i class="bi bi-calendar2-week float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-1 fw-bold">{{ __('Last 7 days') }}</div>
            <div class="text-muted mb-2 small">{{ date('d M Y', strtotime('-7 days')) }} - {{ date('d M Y', strtotime('-1 days')) }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">{{ $stats_last_7_days_visitors ?? '-' }} {{ __('visitors') }} <i class="bi bi-dot"></i> {{ $stats_last_7_days_views ?? '-' }} {{ __('views') }}</div>
            <a class="btn btn-light"
                href="{{ route('site.reports', ['code' => $site->code, 'range' => date('Y-m-d', strtotime('-7 days')) . '_' . date('Y-m-d', strtotime('-1 days'))]) }}">{{ __('View report') }}</a>
        </div>
    </div>


    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box bg-white rounded border border-2 border-secondary">
            <i class="bi bi-calendar2-check float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-1 fw-bold">{{ __('Last 30 days') }}</div>
            <div class="text-muted mb-2 small">{{ date('d M Y', strtotime('-30 days')) }} - {{ date('d M Y', strtotime('-1 days')) }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">{{ $stats_last_30_days_visitors ?? '-' }} {{ __('visitors') }} <i class="bi bi-dot"></i> {{ $stats_last_30_days_views ?? '-' }} {{ __('views') }}</div>
            <a class="btn btn-light"
                href="{{ route('site.reports', ['code' => $site->code, 'range' => date('Y-m-d', strtotime('-30 days')) . '_' . date('Y-m-d', strtotime('-1 days'))]) }}">{{ __('View report') }}</a>
        </div>
    </div>

</div>
<!-- end row -->


<div class="row">

    @if ($stats_traffic)
        {{--
        <div id="columnchart_material" style="width: 100%; height: 500px;"></div>
        --}}

        <div class="col-md-6 col-12 mb-3">
            <div class="card">
                <div class="card-body">


                    <div>
                        <canvas id="chartStats"></canvas>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-md-6 col-12 mb-3">
            <div class="card">
                <div class="card-body">

                    <div class="text-muted small ms-2 float-end">{{ __('Live data updated every 20 seconds.') }}</div>

                    <div class="fw-bold fs-5 mb-0"><i class="bi bi-broadcast"></i> {{ __('Live visits in last 30 minutes') }}</div>                    

                    <div class="clearfix"></div>
                    <div class="mb-2"></div>
                    
                    <livewire:live :site_code="$site->code" />

                </div>
            </div>
        </div>
    @endif

    <div class="col-md-6 col-12">

        <div class="card">

            <div class="card-body">

                <div class="fw-bold fs-5 mb-2">{{ __('Last visitors') }}</div>

                @foreach ($recent_visitors as $recent_visit)
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
            </div>
            <!-- end card-body -->

        </div>

    </div>


    <div class="col-md-6 col-12">

        <div class="card">

            <div class="card-body">

                <div class="fw-bold fs-6 mb-3">{{ __('Last visited pages') }}</div>

                @foreach ($recent_distinct_pages as $recent_page)
                    <tr>
                        <th>
                            <a target="_blank" title="{{ $recent_page->page->domain }}/{{ $recent_page->page->page }}"
                                href="https://{{ $recent_page->page->domain }}{{ $recent_page->page->page }}">{{ $recent_page->page->title }}</a>
                            <div class="small text-muted mb-0">
                                <b>{{ $recent_page->page->domain }}</b>{{ $recent_page->page->page }}
                            </div>
                            <div class="small mb-2">{{ $recent_page->time_diff_human }}</div>
                        </th>

                        <th>
                            {{ $recent_page->sessions_count }}
                        </th>

                        <th>
                            {{ $recent_page->visitors_count }}
                        </th>

                        <th>

                        </th>

                    </tr>
                @endforeach

            </div>

        </div>
    </div>

</div>


<script>
    const ctx = document.getElementById('chartStats');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                @foreach ($stats_traffic as $stats_day)
                    "{{ date_format(date_create($stats_day->day), 'd M') }}",
                @endforeach
            ],
            datasets: [{
                    label: 'Visitors',
                    data: [
                        @foreach ($stats_traffic as $stats_day)
                            {{ $stats_day->visitors }},
                        @endforeach
                    ],
                    borderWidth: 3
                },
                {
                    label: 'Views',
                    data: [
                        @foreach ($stats_traffic as $stats_day)
                            {{ $stats_day->views }},
                        @endforeach
                    ],
                    borderWidth: 2
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
