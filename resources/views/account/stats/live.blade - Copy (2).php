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
    <a class="btn btn-light btn-sm btn-gear text-white" href="{{ route('user.site.show', ['code' => $site->code]) }}"><i class="bi bi-arrow-repeat"></i> {{ __('Reload') }}</a>
</div>

<div class="page-title">
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.sites.index') }}">{{ __('Websites') }}</a></li>
            <li class="breadcrumb-item active">{{ $site->label }}</li>
        </ol>
    </nav>
</div>


@php
    $chartOptions = ['library' => 'chartjs', 'title' => 'Chart Title', 'builder' => $builder, 'poll' => 10, 'width' => '100%', 'height' => 650 /* ... */];
@endphp

<div class="col-12 mb-3">
    <div class="card">
        <div class="card-body">

            @livewire('livecharts-bar-chart', $chartOptions)


        </div>
    </div>


</div>
<div class="row">

    @if ($data)
        {{--
        <div id="columnchart_material" style="width: 100%; height: 500px;"></div>
        --}}

        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">


                    <div>
                        <canvas id="chartStats"></canvas>
                    </div>

                </div>
            </div>
        </div>
    @endif


</div>

{{--

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('chartStats');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                @foreach ($data as $stats_day)
                    "{{ date_format(date_create($stats_day->day), 'd M') }}",
                @endforeach
            ],
            datasets: [{
                    label: 'Visitors',
                    data: [
                        @foreach ($data as $stats_day)
                            {{ $stats_day->visitors }},
                        @endforeach
                    ],
                    borderWidth: 1
                },
                {
                    label: 'Views',
                    data: [
                        @foreach ($data as $stats_day)
                            {{ $stats_day->views }},
                        @endforeach
                    ],
                    borderWidth: 1
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
--}}