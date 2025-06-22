<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('central.user') }}">{{ __('My website / workspace') }}</a></li>
                    <li class="breadcrumb-item active">{{ $tenant->label }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="row">

    <div class="col-md-8 col-12">

        <div class="card">

            <div class="card-body">

                <div class="fw-bold fs-5 mb-2">{{ $tenant->label }}</div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        @if ($message == 'created')
                            {{ __('Created') }}
                        @endif
                        @if ($message == 'updated')
                            {{ __('Updated') }}
                        @endif
                        @if ($message == 'deleted')
                            {{ __('Deleted') }}
                        @endif
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        @if ($message == 'duplicate_label')
                            {{ __('Error. There is another item with this label.') }}
                        @endif
                        @if ($message == 'duplicate_subdomain')
                            {{ __('Error. Subdomain is not available.') }}
                        @endif
                    </div>
                @endif

                <div class="small text-muted mb-2">{{ __('Created at') }} {{ date_locale($tenant->created_at, 'datetime') }}</div>

                <div class="">
                    {{ __('Website URL') }}: <a target="_blank" href="https://{{ $tenant->domain->domain }}"><b>https://{{ $tenant->domain->domain }}</b></a>
                    <div class="mb-2">
                        {{ __('Backend area (login area for administrators, internal users and registered users)') }}:
                        <a target="_blank" href="https://{{ $tenant->domain->domain }}/login"><b>{{ __('Login page') }}</b></a>
                    </div>
                </div>

                <hr>

                @if (!$tenant->domain->custom_domain_created_at)
                    <div class="fs-6 fw-bold text-warning mb-1">{{ __('Custom domain not connected') }}</div>

                    <a class="btn btn-light" href="{{ route('central.user.tenant.connect', ['id' => $tenant->id]) }}"><i class="bi bi-link"></i> {{ __('Connect domain') }}</a>
                @else
                    <div class="fs-6 fw-bold text-success">{{ __('Custom domain connected') }}</div>
                @endif

            </div>
            <!-- end card-body -->

        </div>

    </div>


    <div class="col-md-4 col-12">

        <div class="card">

            <div class="card-body">
                <div class="fw-bold fs-6 mb-3">{{ __('Subscription details') }}</div>


                @if ($user->subscribed($tenant->id))
                    <div class="text-success fw-bold mb-3">
                        <i class="bi bi-check-circle"></i> {{ __('Subscription active') }}
                    </div>
                @else
                    <div class="text-danger fw-bold mb-3">
                        {{ __('No subscription') }}
                    </div>
                @endif

                @if ($user->subscription($tenant->id) ?? null)
                    @if ($user->subscription($tenant->id)->onTrial())
                        <div class="fw-bold text-danger mb-2">
                            <i class="bi bi-info-circle"></i> {{ __('Warning! Yor subscription is on trial period') }}
                        </div>
                        @if ($subscription->trial_ends_at ?? null)
                            <div class="mb-3 small">
                                {{ __('Trial ends at') }}: {{ date_locale($subscription->trial_ends_at, 'datetime') }}
                            </div>
                        @endif
                    @endif

                    @if ($user->subscription($tenant->id)->canceled())
                        <div class="fw-bold text-secondary mb-2">
                            <i class="bi bi-info-circle"></i> {{ __('Subscription was canceled') }}
                        </div>
                        @if ($subscription->ends_at ?? null)
                            <div class="mb-3 small">
                                {{ __('Subscription ends at') }}: {{ date_locale($subscription->ends_at, 'datetime') }}
                            </div>
                        @endif
                    @endif
                @endif

                @if ($next_billing_date ?? null)
                    {{ __('Next billing date') }}: {{ $next_billing_date }}
                @endif

                <hr>

                <div class="mb-1 fw-bold">
                    {{ __('Go to billing portal to: ') }}
                </div>

                <div class="mb-2">
                    <i class="bi bi-check"></i> Upgrade or downgrade subscriptions<br>
                    <i class="bi bi-check"></i> Cancel or resume a subscription<br>
                    <i class="bi bi-check"></i> Manage payment methods<br>
                    <i class="bi bi-check"></i> Manage billing details<br>
                    <i class="bi bi-check"></i> View all invoices
                </div>

                <a class="btn btn-gear btn-lg mb-2" target="_blank" href="{{ $portalSessionUrl }}"><i class="bi bi-credit-card"></i> {{ __('Go to billing portal') }}</a>

                <div class="text-muted small">{{ __('In the billing portal you have access to manage all your Nura products and subscriptions.') }}</div>
                <div class="text-muted small mt-2"> <i class="bi bi-info-circle"></i>
                    {{ __('Tip: if you have multiple products with same subscription name and same pricing  (Example: multiple  websites with "NuraPress Solo" subscription), you can check the "next billing date" to identify the correct subscription for "' . $tenant->label . '"') }}
                </div>


            </div>

        </div>
    </div>

</div>
