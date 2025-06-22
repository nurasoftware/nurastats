<div class="card">

    <div class="card-header">
        <div class="fw-bold fs-5">{{ __('Top pages') }}</div>
    </div>

    <div class="card-body">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">{{ __('Page details') }}</th>
                    <th scope="col" width="100">{{ __('Pageviews') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($top_pages as $page_item)
                    @if ($loop->index < 50)
                        <tr>
                            <th>
                                <div class="text-muted fw-bold mb-2">
                                    {{ $page_item['title'] }}
                                </div>
                                <div class="small text-muted text-clamp-1 fw-normal">
                                    {{ $page_item['url'] }}

                                    <span class="ms-2 fw-normal"><a target="_blank" title="{{ __('Visit website: ') }}"
                                            href="https://{{ $site->url }}{{ $page_item['url'] }}"><i class="bi bi-box-arrow-up-right"></i></a></span>

                                    <span class="ms-2 fw-normal"><a title="{{ __('Page history') }}"
                                            href="{{ route('user.site.page_stats', ['code' => $site->code, 'hash' => $page_item['page_hash']]) }}"><i class="bi bi-graph-up"></i></a>
                                </div>
                            </th>

                            <th>
                                {{ $page_item['counter'] }}
                            </th>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    </div>
    <!-- end card-body -->

</div>
