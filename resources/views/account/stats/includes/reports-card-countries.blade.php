<div class="card">

    <div class="card-header">
        <div class="fw-bold fs-5">{{ __('Visitors by countries') }}</div>
    </div>

    <div class="card-body">

        <div>
            <canvas id="chartCountries"></canvas>
        </div>

        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col" width="150">{{ __('Date') }}</th>
                    <th scope="col">{{ __('Countries visits') }}</th>
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
                                    $countries_array = json_decode($item->countries) ?? [];
                                @endphp

                                @if (count($countries_array) > 0)
                                    @foreach ($countries_array as $c)
                                        <span class="me-2">
                                            <img style="width: 20px; height: 20px;" src="{{ config('app.cdn') }}/assets/img/flags/circle/{{ strtolower($c->code) }}.svg" alt="{{ $c->country }}"> <b>{{ $c->country }}
                                                ({{ $c->counter }})
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
    const ctx_countries = document.getElementById('chartCountries');

    new Chart(ctx_countries, {
        type: 'bar',
        data: {
            labels: [
                @foreach ($countries as $chart_country)
                    @if ($loop->index < 10)
                        ["{{ $chart_country['country'] }}"],
                    @endif
                @endforeach
            ],
            datasets: [{
                label: 'Country visits',
                data: [
                    @foreach ($countries as $chart_country)
                        @if ($loop->index < 10)
                            "{{ $chart_country['counter'] }}",
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
                },
            }
        }
    });
</script>
