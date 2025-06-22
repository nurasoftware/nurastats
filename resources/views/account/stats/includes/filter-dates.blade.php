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
</div>

<div class="mb-3">
    <form method="GET" class="row row-cols-lg-auto g-3 align-items-center">
        <div class="col-12">
            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 7px 10px; border: 1px solid #cdbfbf; width: auto; color: #56728b">
                <i class="bi bi-calendar-check"></i>&nbsp;
                <span></span> <i class="bi bi-caret-down-fill"></i>
            </div>
        </div>

        <div class="col-12">
            <input name="range" type="hidden" id="rangeInput">
            <button type="submit" class="btn btn-light btn-gear text-white">{{ __('Show report') }}</button>
        </div>
    </form>
</div>

<script>
    $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
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