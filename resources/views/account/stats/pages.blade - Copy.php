<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.sites.index') }}">{{ __('Websites') }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('user.site.show', ['code' => $site->code]) }}">{{ $site->label }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Pages') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{--
<div class="fw-bold fs-5 mb-2">
    @if ($range_start == $range_end)
        @if ($range_start == $date_today)
            {{ __('Today') }}
        @elseif($range_start == $date_yesterday)
            {{ __('Yesterday') }}
        @else
            {{ $range_start }}
        @endif
    @else
        {{ date('d M', strtotime($range_start)) }} - {{ date('d M', strtotime($range_end)) }}
    @endif
    ({{ $pages->total() }} {{ __('pages') }})
</div>

<div class="mb-3">
    <form method="GET" class="row row-cols-lg-auto g-3 align-items-center">
        <div class="col-12">
            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: auto">
                <i class="bi bi-calendar-check"></i>&nbsp;
                <span></span> <i class="bi bi-caret-down-fill"></i>
            </div>
        </div>

        <div class="col-12">
            <input name="range" type="hidden" id="rangeInput">
            <button type="submit" class="btn btn-light btn-gear text-white">{{ __('Show stats') }}</button>
        </div>
    </form>
</div>
--}}

<div class="row">

    <div class="col-12">

        <div class="card">

            @include('user.stats.includes.menu-pages')

            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Page details</th>
                            <th scope="col">Views</th>
                            <th scope="col">Visitors</th>
                            <th scope="col">Stats</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            {{-- dd($page->count_sessions) --}}
                            <tr>
                                <th>
                                    <a target="_blank" title="{{ $page->page->domain }}/{{ $page->page->page }}" href="https://{{ $page->page->domain }}{{ $page->page->page }}">{{ $page->page->title }}</a>
                                    <div class="small text-muted mb-2">
                                        <b>{{ $page->page->domain }}</b>{{ $page->page->page }}
                                    </div>
                                </th>

                                <th>
                                    {{ $page->sessions_count }}
                                </th>

                                <th>
                                    {{ $page->visitors_count }}
                                </th>

                                <th>
                                    <i class="bi bi-graph-up"></i> <a href="{{ route('user.site.page_stats', ['code' => $site->code, 'hash' => $page->page->hash])}}">{{ __('Page stats') }}</a>
                                </th>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $pages->links() }}
            </div>
            <!-- end card-body -->

        </div>

    </div>    

</div>

<script>
    $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            //$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            //$('#reportrange span').html(start.format('YYYY-M-D') + ' - ' + end.format('YYYY-M-D'));
            $('#reportrange span').html('{{ $range_start }} - {{ $range_end }}');
        }

        $('#reportrange').daterangepicker({
            //startDate: start,
            startDate: '{{ $range_start }}',
            //endDate: end,
            endDate: '{{ $range_end }}',
            ranges: {
                'Today': ['{{ $date_today }}', '{{ $date_today }}'],
                'Yesterday': ['{{ $date_yesterday }}', '{{ $date_yesterday }}'],
                'Last 7 Days': ['{{ $date_7_days_ago }}', '{{ $date_yesterday }}'],
                'Last 30 Days': ['{{ $date_30_days_ago }}', '{{ $date_yesterday }}'],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "locale": {
                "format": "YYYY-MM-DD",
                "separator": " - ",
                "applyLabel": "Apply",
                "cancelLabel": "Cancel",
                "fromLabel": "From",
            },
        }, cb);

        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            var rangeStart = picker.startDate.format('YYYY-MM-DD');
            var rangeEnd = picker.endDate.format('YYYY-MM-DD');
            $('#rangeInput').val(rangeStart + '_' + rangeEnd);
        });

        cb(start, end);
    });
</script>
