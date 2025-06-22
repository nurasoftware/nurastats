<div>
    <div wire:poll.20s.visible>

        <div class="row mb-3">
            <div class="col-4">
                <div class="fw-bold">{{ __('Last 5 minutes') }}</div>
                <div style="font-size: 2em;">
                    @if ($live_last_5_min > 499)
                        >
                    @endif
                    {{ $live_last_5_min }}
                </div>
            </div>

            <div class="col-4">
                <div class="fw-bold">{{ __('Last 15 minutes') }}</div>
                <div style="font-size: 2em;">
                    @if ($live_last_15_min > 499)
                        >
                    @endif
                    {{ $live_last_15_min }}
                </div>
            </div>

            <div class="col-4">
                <div class="fw-bold">{{ __('Last 30 minutes') }}</div>
                <div style="font-size: 2em;">
                    @if ($live_last_30_min > 499)
                        >
                    @endif
                    {{ $live_last_30_min }}
                </div>
            </div>
        </div>


        @foreach ($live_sessions as $live_session)
            @if ($loop->index < 6)
                <div class="mb-2">
                    <div class="fw-bold text-clamp-1">
                        {{ $live_session->page->title }}
                        <span class="ms-2 fw-normal"><a target="_blank" title="{{ __('Visit website: ') }} https://{{ $live_session->page->domain }}{{ $live_session->page->page }}"
                                href="https://{{ $live_session->page->domain }}{{ $live_session->page->page }}"><i class="bi bi-box-arrow-up-right"></i></a></span>

                        <span class="ms-2 fw-normal"><a title="{{ __('Page history') }}"
                                href="{{ route('user.site.page_stats', ['code' => $live_session->site->code, 'hash' => $live_session->page->hash]) }}"><i class="bi bi-graph-up"></i></a>
                    </div>


                    <div class="fw-bold text-muted small">
                        <i class="bi bi-clock"></i> {{ date('M d, H:i', strtotime($live_session->created_at)) }}

                        <img class="ms-3" style="width: 22px; height: 22px;" src="{{ config('app.cdn') }}/assets//img/flags/circle/{{ strtolower($live_session->visitor->geo_cc) }}.svg"
                            alt="{{ $live_session->visitor->geo_country }}"> {{ $live_session->visitor->geo_country }} /
                        {{ $live_session->visitor->geo_region_name ?? $live_session->visitor->geo_region }} / {{ $live_session->visitor->geo_city }}
                    </div>
                </div>
            @endif
        @endforeach

    </div>

</div>
