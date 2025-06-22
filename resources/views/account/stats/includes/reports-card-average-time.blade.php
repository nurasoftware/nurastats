<div class="card">

    <div class="card-header">
        <div class="fw-bold fs-5">{{ __('Average time spent on website (in seconds)') }}</div>
    </div>

    <div class="card-body">

        <div>
            <canvas id="chartAverageTime"></canvas>
        </div>

    </div>
    <!-- end card-body -->

</div>


<script>
    const ctx_average_time = document.getElementById('chartAverageTime');

    new Chart(ctx_average_time, {
        type: 'bar',
        data: {
            labels: [
                @foreach ($stats_traffic as $stats_day)
                    "{{ date_format(date_create($stats_day->day), 'd M') }}",
                @endforeach
            ],
            datasets: [{
                label: 'Average time (seconds)',
                data: [
                    @foreach ($stats_traffic as $stats_day)
                        {{ $stats_day->average_time }},
                    @endforeach
                ],
                backgroundColor: [
                    @foreach ($stats_traffic as $stats_day)
                        @if ($stats_day->average_time < 10)
                            'rgb(188, 30, 30, 0.5)',
                        @elseif ($stats_day->average_time >= 10 && $stats_day->average_time < 20)
                            'rgb(193, 58, 58, 0.5)',
                        @elseif ($stats_day->average_time >= 20 && $stats_day->average_time < 40)
                            'rgb(255, 158, 56, 0.5)',
                        @elseif ($stats_day->average_time >= 40 && $stats_day->average_time < 80)
                            'rgb(38, 138, 181, 0.5)',
                        @elseif ($stats_day->average_time >= 80 && $stats_day->average_time < 150)
                            'rgb(17, 60, 160, 0.5)',
                        @elseif ($stats_day->average_time >= 150 && $stats_day->average_time < 200)
                            'rgb(16, 137, 11, 0.5)',
                        @elseif ($stats_day->average_time >= 200)
                            'rgb(50, 147, 8, 0.5)',
                        @endif
                    @endforeach                    

                ],
                borderColor: [
                    'rgba(70, 70, 70)',                    
                ],
                borderWidth: 2
            }, ]
        },
        options: {
            plugins: {
                legend: {
                    display: false,                    
                }
            },   
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
