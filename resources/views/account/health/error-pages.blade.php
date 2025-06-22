<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.sites.index') }}">{{ __('Websites') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.site.show', ['code' => $site->code]) }}">{{ $site->label }}</a></li>
                    <li class="breadcrumb-item active">{{ __('404/Error pages') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card">

    <div class="card-body">

        <div class="fw-bold mb-3">{{ __('Track what the URL is for 404/Error pages on your site') }}</div>

        <div class="fw-bold mb-1">{{ __('Note: You must have a dedicated template for your 404 page (most of the CMSs have this option)') }}</div>

        <div class="mb-2">
            {!! __('Track this 404/Error pages by adding the attribute <b>data-clevada-analytics-error="1"</b> in the analytics script of your 404 template page.') !!}
        </div>

        <textarea class="form-control" rows="2" id="t1"><script async src="https://cdn.clevada.com/analytics.js" data-site="{{ $site->code }}" data-clevada-analytics-error="1"></script></textarea>
        <button id="buttonCopy1" class="btn btn-sm btn-secondary mt-2">{{ __('Copy code') }}</button>
        <div id="copied1" class="text-success mt-2 fw-bold d-none">{{ __('Tracker code copied. You can paste it in your website') }}</div>
        <script>
            $("#buttonCopy1").click(function() {
                $("textarea#t1").select();
                document.execCommand('copy');
                $("div#copied1").removeClass("d-none");
                $("div#copied1").addClass("d-block");
            });
        </script>


    </div>

</div>



<div class="card">

    <div class="card-body">

        <div class="fw-bold fs-5 mb-3">{{ __('404/Error pages') }} ({{ $pages->total() }})</div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">{{ __('Date') }}</th>
                    <th scope="col">{{ __('URL path') }}</th>
                    <th scope="col">{{ __('Visitor details') }}</th>
                    <th scope="col">{{ __('Counter') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>
                            <div class="mb-2 fw-bold">{{ date_locale($page->created_at, 'F d, Y, H:i') }}</div>
                        </td>


                        <td>
                            <div class="mb-2 fw-bold">{{ $page->path }}</div>

                            {{ __('Referrer') }}:
                            @if ($page->referrer)
                                <a target="_blank" class="small" href="https://{{ $page->referrer }}">{{ $page->referrer }}</a>
                            @else
                                - ({{ __('direct visit') }})
                            @endif
                        </td>

                        <td>
                            @php
                                $data2 = json_decode($page->data);
                                if ($data2[0] ?? null) {
                                    $data_decoded = $data2[0];

                                    $ip = $data_decoded->ip ?? null;
                                    $device_type = $data_decoded->device_type ?? null;
                                    $platform_family = $data_decoded->platform_family ?? null;
                                    $platform_name = $data_decoded->platform_name ?? null;
                                    $platform_version = $data_decoded->platform_version ?? null;
                                    $browser_family = $data_decoded->browser_family ?? null;
                                    $browser_name = $data_decoded->browser_name ?? null;
                                    $device_family = $data_decoded->device_family ?? null;
                                    $device_model = $data_decoded->device_model ?? null;
                                    $geo_cc = $data_decoded->geo_cc ?? null;
                                    $geo_country = $data_decoded->geo_country ?? null;
                                    $geo_region = $data_decoded->geo_region ?? null;
                                    $geo_region_name = $data_decoded->geo_region_name ?? null;
                                    $geo_city = $data_decoded->geo_city ?? null;
                                }
                            @endphp

                            @if ($geo_cc ?? null)
                                <div class="float-start me-2"><img src="https://analytics-cdn.clevada.com/img/flags/{{ strtolower($geo_cc) }}.png" alt="{{ $geo_country ?? null }}">
                                </div>
                                {{ $geo_city ?? null }}, {{ $geo_country ?? null }} <i class="bi bi-dot"></i> <span class="text-muted small fw-normal">{{ $ip ?? null }}</span>
                            @endif

                            <div class="fw-normal">
                                @if ($device_type == 'm')
                                    <i class="bi bi-phone" title="{{ __('Mobile device') }}"></i>
                                    @if (($device_family ?? null) && !(($device_family ?? null) == 'Unknown' || ($device_family ?? null) == 'K'))
                                        {{ $device_family . ' ' . $device_model }}
                                    @else
                                        {{ __('Mobile device') }}
                                    @endif
                                @elseif($device_type == 'd')
                                    <i class="bi bi-display" title="{{ __('Desktop PC') }}"></i> {{ __('Desktop PC') }}
                                @elseif($device_type == 't')
                                    <i class="bi bi-tablet-landscape" title="{{ __('"Tablet') }}"></i> {{ __('"Tablet') }}
                                @elseif($device_type == 'b')
                                    <i class="bi bi-search" title="{{ __('Bot / Crawler') }}"></i> {{ __('Bot / Crawler') }}
                                @endif

                                <div class="clearfix"></div>

                                @if ($browser_family == 'Chrome')
                                    <i class="bi bi-browser-chrome" title="Chrome"></i> Chrome
                                @elseif($browser_family == 'Safari')
                                    <i class="bi bi-browser-safari" title="Safari"></i> Safari
                                @elseif($browser_family == 'Microsoft Edge')
                                    <i class="bi bi-browser-edge" title="Microsoft Edge"></i> Microsoft Edge
                                @elseif($browser_family == 'Firefox')
                                    <i class="bi bi-browser-firefox" title="Firefox"></i> Firefox
                                @elseif ($browser_family == 'Chrome Mobile')
                                    <i class="bi bi-browser-chrome" title="Chrome Mobile"></i> Chrome Mobile
                                @elseif ($browser_family == 'HeadlessChrome')
                                    <i class="bi bi-browser-chrome" title="HeadlessChrome"></i> HeadlessChrome
                                @elseif ($browser_family == 'Mobile Safari')
                                    <i class="bi bi-browser-safari" title="Mobile Safari"></i> Mobile Safari
                                @else
                                    <i class="bi bi-window" title="{{ $browser_family }}"></i> {{ $browser_family }}
                                @endif

                                <i class="bi bi-dot"></i> {{ $platform_name }}
                            </div>
                        </td>

                        <td>
                            {{ $page->counter }}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $pages->links() }}

    </div>
    <!-- end card-body -->

</div>
