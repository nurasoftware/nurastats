<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('sites.index') }}">{{ __('Websites') }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('site.show', ['code' => $site->code]) }}">{{ $site->label }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Reports') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@include('account.stats.includes.filter-dates')

<div class="row">    

    <div class="col-12 col-lg-6">

        @include('account.stats.includes.reports-card-traffic')

        @include('account.stats.includes.reports-card-average-time')

        @include('account.stats.includes.reports-card-devices')

        @include('account.stats.includes.reports-card-top-pages')

    </div>


    <div class="col-12 col-lg-6">

        @include('account.stats.includes.reports-card-countries')

        @include('account.stats.includes.reports-card-referrers')

    </div>   

</div>
