<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('central.user') }}">{{ __('My website / workspace') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('central.user.tenant.show') }}">{{ $tenant->label }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Connect domain') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-body">

        <div class="fw-bold fs-5 mb-2">{{ __('Connect your domain for') }} {{ $tenant->domain->clevada_subdomain }}</div>


        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                @if ($message == 'created')
                    {{ __('Connected') }}
                @endif
                @if ($message == 'cname_verified')
                    {{ __('CNAME Verified.') }}
                @endif
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger">
                @if ($message == 'invalid_domain')
                    {{ __('Error. Invalid domain or subdomain name.') }}
                @endif
                @if ($message == 'error_connect_trial_active')
                    {{ __('Error. You can not connect a domain in trial period. Please subscribe.') }}
                @endif
                @if ($message == 'error_connect_no_subscription')
                    {{ __('Error. You must have an active subscription to connect your domain.') }}
                @endif
                @if ($message == 'cname_not_found')
                    {{ __('Error. CNAME not set. Please check your CNAME and try again.') }}
                @endif
                @if ($message == 'addon_creation_error')
                    {{ __('Server error. Please try again later. Error code: ADDON DOMAIN CREATION FAILED.') }}
                @endif
            </div>
        @endif

        @if ($tenant->custom_domain_created_at)
            <div class="fw-bold text-success">{{ __('You alreadu conect your custom domain') }}</div>

            <div class="small text-muted">{{ __('Domain connected at') }} {{ date_locale($tenant->custom_domain_created_at) }}</div>
        @endif

        <hr>

        @if ($is_paid_subscription == 0)
            <div class="fw-bold text-danger">{{ __('You can not connect your domain in trial mode. Please upgrade to paid plan now to connect your domain.') }}</div>
            <a class="btn btn-gear mt-2" href="{{ route('central.user.subscription') }}"><i class="bi bi-check2-circle"></i> {{ __('Upgrade plan') }}</a>
        @else
            <div class="alert alert-light mb-3">
                <b><i class="bi bi-info-circle"></i> {{ __('Connect domain or subdomain.') }}</b>
                <br>
                Examples: <br>
                Conect your main domain: "www.mydomain.com". You MUST add "www" prefix if you want to connect your main domain.<br>
                Connect a subdomain: "blog.mydomain.com".
                <hr>
                {{ __('You must own domain name and have access to domain management to update DNS zone (you must create a CNAME record).') }}
                <br>
                If you need more info or support to connect your domain, you can open a <a href="{{ route('central.user.tickets') }}" class="fw-bold">support ticket</a>.
            </div>

            <div class="fs-5 fw-bold">STEP 1. Update DNS Zone</div>
            <b>You must login to your domain registar panel and add a CNAME record.</b>
            <div class="mb-2"></div>

            Zone name: Your domain or subdomain which you want to connect. Example: "www.mydomain.com" or "blog.mydomain.com"<br>
            Record type: <b>CNAME</b><br>
            Record value: <b>{{ $tenant->domain->clevada_subdomain }}</b>
            <hr>

            <div class="fs-5 fw-bold">STEP 2. Add your domain</div>

            <form method="POST">
                {{ csrf_field() }}

                <label for="basic-url" class="form-label">{{ __('Input your domain or subdomain.') }}</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon3">https://</span>
                    <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="connected_domain" value="{{ $connected_domain ?? null }}" required>
                </div>

                @if ($tenant->domain->custom_domain_verified_at)
                    <button type="submit" class="btn btn-gear">{{ __('Connect domain') }}</button>
                @else
                    <div class="fw-bold text-danger mt-2 mb-2"><i class="bi bi-minus-circle-circle"></i> CNAME not set. Please check your CNAME and try again.</div>
                    <button type="submit" class="btn btn-gear">Verify CNAME record</button>
                @endif


            </form>
        @endif

    </div>
    <!-- end card-body -->

</div>
