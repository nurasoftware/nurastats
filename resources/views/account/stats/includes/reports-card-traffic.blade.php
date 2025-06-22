<div class="card">

    <div class="card-header">
        <div class="fw-bold fs-5">{{ __('Website traffic') }}</div>
    </div>

    <div class="card-body">

        <div>
            <canvas id="chartStats"></canvas>
        </div>

    </div>
    <!-- end card-body -->

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
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
