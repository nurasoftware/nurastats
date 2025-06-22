<div class="card">

    <div class="card-header">
        <div class="fw-bold fs-5">{{ __('Traffic source (referrers)') }}</div>
    </div>

    <div class="card-body">

        <div>
            <canvas id="chartReferrers"></canvas>
        </div>

        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col" width="150">{{ __('Date') }}</th>
                    <th scope="col">{{ __('Referrers') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stats_traffic as $item)
                    <tr>
                        <th>
                            {{ date('d M Y', strtotime($item->day)) }}
                        </th>

                        <th>
                            <div class="small text-muted mb-2">
                                @php
                                    $referrers_array = json_decode($item->referrers) ?? [];
                                @endphp

                                @if (count($referrers_array) > 0)
                                    @foreach ($referrers_array as $ref)
                                        <span class="me-2">
                                            <b>
                                                {{ $ref->host }} ({{ $ref->counter }})
                                            </b>
                                        </span>
                                    @endforeach
                                @else
                                    {{ __('No data') }}
                                @endif
                            </div>
                        </th>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <!-- end card-body -->

</div>


<script>
    const ctx_referrers = document.getElementById('chartReferrers');

    new Chart(ctx_referrers, {
        type: 'bar',
        data: {
            labels: [
                @foreach ($referrers as $chart_referrer)
                    @if ($loop->index < 20)
                        ["{{ $chart_referrer['host'] }}"],
                    @endif
                @endforeach
            ],
            datasets: [{
                label: 'Referrer visits',
                data: [
                    @foreach ($referrers as $chart_referrer)
                        @if ($loop->index < 20)
                            "{{ $chart_referrer['counter'] }}",
                        @endif
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',

                ],
                borderColor: [
                    'rgb(54, 162, 235)',
                    'rgb(75, 192, 192)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    'rgb(54, 162, 235)',
                    'rgb(75, 192, 192)',
                    'rgb(255, 99, 132)',
                ],
                borderWidth: 2

            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false,
                }
            },
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
