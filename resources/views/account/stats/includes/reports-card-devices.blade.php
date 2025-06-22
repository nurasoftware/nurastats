<div class="card">

    <div class="card-header">
        <div class="fw-bold fs-5">{{ __('Devices') }}</div>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-6">
                <div>
                    <canvas id="chartDevices"></canvas>
                </div>
            </div>


            <div class="col-md-6">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" width="150">{{ __('Date') }}</th>
                            <th scope="col">{{ __('Devices') }}</th>
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
                                            $devices_array = json_decode($item->devices) ?? [];
                                        @endphp

                                        @if (count($devices_array) > 0)
                                            @foreach ($devices_array as $d)
                                                <span class="me-2">
                                                    @if ($d->type == 'm')
                                                        <i class="bi bi-phone" title="{{ __('Mobile device') }}"></i> {{ __('Mobile') }}
                                                    @elseif($d->type == 'd')
                                                        <i class="bi bi-display" title="{{ __('Desktop PC') }}"></i> {{ __('Desktop') }}
                                                    @elseif($d->type == 't')
                                                        <i class="bi bi-tablet-landscape" title="{{ __('Tablet') }}"></i> {{ __('Tablet') }}
                                                    @elseif($d->type == 'b')
                                                        <i class="bi bi-search" title="{{ __('Bot / Crawler') }}"></i> {{ __('Bot / Crawler') }}
                                                    @endif

                                                    <b>({{ $d->counter }})</b>
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

        </div>

    </div>
    <!-- end card-body -->

</div>


<script>
    const ctx_devices = document.getElementById('chartDevices');

    new Chart(ctx_devices, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach ($devices as $chart_device)
                    @php
                        if ($chart_device['type'] == 'm') {
                            $type = __('Mobile');
                        } elseif ($chart_device['type'] == 'd') {
                            $type = __('Desktop');
                        } elseif ($chart_device['type'] == 't') {
                            $type = __('Tablet');
                        } elseif ($chart_device['type'] == 'b') {
                            $type = __('Bot / crawler');
                        } else {
                            $type = $chart_device['type'];
                        }
                    @endphp
                        ["{{ $type }}"],
                @endforeach
            ],
            datasets: [{
                label: 'Visitors',
                data: [
                    @foreach ($devices as $chart_device)
                        {{ $chart_device['counter'] }},
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
                borderWidth: 1

            }]
        },        
    });
</script>
