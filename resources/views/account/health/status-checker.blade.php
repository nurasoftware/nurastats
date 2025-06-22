<style>
    .service-status>.service-status--graph {
        display: block;
    }

    .incidents-history-graph {
        text-align: right;
        padding-top: 20px;
    }

    .incidents-history-graph .segments {
        display: flex;
        position: relative;
    }

    .service-status .incidents-history-graph .segments>div {
        height: 30px;
    }

    .incidents-history-graph .segments .segment {
        height: 40px;
        flex: 1;
        padding: 0;
        margin-right: 2px;
    }

    @media (max-width: 576px) {
        .incidents-history-graph .segments .segment {
            margin-right: 1px;
        }
    }

    .service-status .incidents-history-graph .time-legends {
        color: #bbb;
    }

    .service-status .incidents-history-graph .time-legends {
        font-size: 0.8rem;
        color: #555;
    }

    .incidents-history-graph .time-legends {
        color: #bbb;
    }

    .incidents-history-graph .time-legends {
        display: flex;
        justify-content: space-between;
        font-weight: 300;
        margin-top: 5px;
    }

    .service-status .service-status--info {
        display: flex;
        align-items: center;
        line-height: 1em;
    }

    .service-status .service-status--name {
        font-weight: 600;
        font-size: 1em;
        flex: 1;
    }

    .service-status--info .service-status--status,
    .service-status--info .service-status--icon {
        color: #48CBA5;
    }

    .service-status .service-status--status {
        font-weight: 600;
    }

    .service-status--info .service-status--status,
    .service-status--info .service-status--icon {
        color: #48CBA5;
    }

    .service-status .service-status--icon {
        font-style: normal;
        transform: scaleX(-1) rotate(-45deg);
        margin-left: 10px;
        border: 2px solid;
        width: 18px;
        height: 18px;
        font-size: 12px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1em;
        font-weight: bold;
        font-family: arial;
    }

    .service-status .service-status--icon:before {
        content: "L";
    }

    .service-status--info .service-status--status--offline,
    .service-status--info .service-status--icon--offline {
        color: #cb485e;
    }

    .service-status .service-status--status--offline {
        font-weight: 600;
    }

    .service-status .service-status--icon--offline {
        font-style: normal;
        margin-left: 10px;
        border: 2px solid;
        width: 19px;
        height: 19px;
        font-size: 11px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1em;
        font-weight: bold;
        font-family: arial;
    }

    .service-status .service-status--icon--offline:before {
        content: "X";
    }

    .service-status--info .service-status--status--issues,
    .service-status--info .service-status--icon--issues {
        color: #ffc355;
    }

    .service-status .service-status--status--issues {
        font-weight: 600;
    }

    .service-status .service-status--icon--issues {
        font-style: normal;
        margin-left: 10px;
        border: 2px solid;
        width: 19px;
        height: 19px;
        font-size: 11px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1em;
        font-weight: bold;
        font-family: arial;
    }

    .service-status .service-status--icon--issues:before {
        content: "!";
    }

    .custom-tooltip .tooltip-inner {
        background-color: #eeeeee !important;
        color: #2e2e2e;
        border: 1px solid #cccccc;
        padding: 10px;
    }

    .bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow::before,
    .bs-tooltip-top .tooltip-arrow::before {
        border-top-color: #ccc !important
    }
</style>

@if (count($last_checks_reverse) > 0)
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Date', 'Response time (seconds)'],
                @foreach ($last_checks_reverse as $check)
                    ["{{ date_format(date_create($check->at), 'H:i') }}", {{ $check->response_time }}],
                @endforeach
            ]);

            var options = {
                'title': 'Response time (seconds)',
                'legend.position': 'bottom',
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
@endif

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.sites.index') }}">{{ __('Websites') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.site.show', ['code' => $site->code]) }}">{{ $site->label }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Website status checker') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box noradius bg-white rounded border border-2 border-primary">
            <i class="bi bi-clock-history float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-4 fw-bold">{{ __('Last 24 hours') }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">100% uptime <i class="bi bi-dot"></i> 0.75s {{ __('average response time') }}</div>
            <a class="btn btn-light" href="{{ route('user.site.status_checker', ['code' => $site->code]) }}">{{ __('View details') }}</a>

        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box noradius noborder bg-white rounded">
            <i class="bi bi-calendar2-week float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-4 fw-bold">{{ __('Last 7 days') }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">100% uptime <i class="bi bi-dot"></i> 0.75s {{ __('average response time') }}</div>
            <a class="btn btn-light" href="#">{{ __('View details') }}</a>
        </div>
    </div>


    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box noradius noborder bg-white rounded">
            <i class="bi bi-calendar2-check float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-4 fw-bold">{{ __('Last 30 days') }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">100% uptime <i class="bi bi-dot"></i> 0.75s {{ __('average response time') }}</div>
            <a class="btn btn-light" href="#">{{ __('View details') }}</a>
        </div>
    </div>


    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box noradius noborder bg-white rounded">
            <i class="bi bi-exclamation-circle float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-4 fw-bold">{{ __('Incidents') }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">{{ $count_pages ?? 0 }} {{ __('last 24 hours') }} <i class="bi bi-dot"></i> {{ $count_pages ?? 0 }} {{ __('last 30 days') }}</div>
            <a class="btn btn-light" href="{{ route('user.site.status_checker', ['code' => $site->code]) }}">{{ __('View details') }}</a>
        </div>
    </div>
</div>
<!-- end row -->

<div class="row">
    <div class="col-12">

        <div class="serviceListItem service-status">

            <div class="service-status--info">
                <span class="service-status--name">
                    {{ $site->url }}
                    <span class="serviceList__description" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" title="The web interface of website."></span>
                </span>
                {{--
                @if (website_status($site_url) == 'online')
                <span class="service-status--status">
                    {{ STATUS_ONLINE_TEXT }}
                </span>
                <i class="service-status--icon"></i>
                @elseif (website_status($site_url) == 'offline')
                <span class="service-status--status--offline">
                    {{ STATUS_OFFLINE_TEXT }}
                </span>
                <i class="service-status--icon--offline"></i>
                @else 
                <span class="service-status--status--offline">
                    {{ STATUS_ISSUES_TEXT }}
                </span>
                <i class="service-status--icon--offline"></i>
                @endif
                --}}
            </div>

            <div class="service-status--graph incidents-history-graph">
                <div class="graph">
                    <!-- content goes here -->
                    <div style="position: relative;">
                        <div class="segments">
                            @foreach ($stats_bars as $bar)
                                <div class="segment {{ $bar['percent'] }}" style="background-color: {{ $bar['color'] }}; position: relative;" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip"
                                    data-bs-html="true" title="{{ $bar['tooltip'] }}"></div>
                            @endforeach
                        </div>
                    </div>

                    <div class="time-legends">
                        <span><span id="service_17085_uptime_history_days">
                                7
                            </span> days ago</span>
                        <span class="uptime">
                            <span id="service_17085_uptime_history_percent">{{ $bar['stat_uptime'] }}</span>% Uptime
                        </span>
                        <span>Today</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-6">
        <div id="chart_div" style="width: 100%; height: 350px;" class="mb-4"></div>
    </div>
</div>

<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="fw-bold fs-5 mb-2">{{ __('Recent checks') }}</div>


                @foreach ($last_checks as $check)
                    <div class="float-end ms-3 fs-3 text-secondary">
                        @if ($check->status_code == 200)
                            <span class="badge text-bg-success">OK</span>
                        @else
                            <span class="badge text-bg-danger">{{ $check->status_code }}</span>
                        @endif
                    </div>


                    <div class="fw-bold">{{ date_format(date_create($check->at), 'M d Y, H:i') }}</div>

                    <div class="clearfix">{{ $check->status_code }}</div>

                    <hr>
                @endforeach
            </div>
            <!-- end card-body -->

        </div>

    </div>

</div>
