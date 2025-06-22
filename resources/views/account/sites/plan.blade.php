<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('central.user.sites') }}">{{ __('My sites') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('central.user.sites.show', ['code' => $site->code]) }}">{{ $site->label }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Upgrade plan') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-body">

        <div class="fw-bold fs-5 mb-2">{{ __('Upgrade plan') }} ({{ $site->domain }})</div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                @if ($message == 'created')
                    {{ __('Connected') }}
                @endif
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger">
                @if ($message == 'exists_site_invoice')
                    {{ __('Error. There is another unpaid invoice related to this site.') }} <a href="{{ route('central.user.invoices') }}">{{ __('Go to invoices') }}</a>
                @endif
            </div>
        @endif


        @if ($site->is_trial == 1)
            <div class="fw-bold text-info">{{ __('Your plan: TRIAL') }}</div>
        @endif


        @if ($site->plan_expire_at ?? null)
            <div class="mt-2">
                {{ __('Plan expire at') }}: {{ date_locale($site->plan_expire_at) }}
            </div>
        @endif

        <hr>

        <div class="fw-bold fs-6 mb-1">{{ __('Extend period') }}</div>

        <div class="text-muted mb-2"><i class="bi bi-info-circle"></i> Extend for one year and get <b>3 months for free</b> (pay for 9 monhts instead 12 months).</div>

        <div class="mb-2 text-muted small">
            New expire date: <b>{{ date_locale($site->plan_expire_at) }}</b> (one month extended) or <b>{{ date_locale($site->plan_expire_at) }}</b> (one year externded).
        </div>

        <a href="{{ route('central.user.sites.extend', ['code' => $site->code, 'months' => 1]) }}" class="btn btn-gear me-2">Extend one month (USD9)</a>


        <a href="{{ route('central.user.sites.extend', ['code' => $site->code, 'months' => 12]) }}" class="btn btn-gear">Extend one year (USD81)</a>

        <div class="clearfix mb-3"></div>


    </div>
    <!-- end card-body -->

</div>
