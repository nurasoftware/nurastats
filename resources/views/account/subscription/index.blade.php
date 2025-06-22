<style>
    .price-btn {
        display: inline-block;
        font-weight: 600 !important;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        padding: 8px 25px;
        font-size: 18px;
        border-radius: 8px;
        color: #263953 !important;
        cursor: pointer;
        z-index: 5;
        transition: all .4s ease-in-out;
        border: none;
        background: #fcbb47;
        overflow: hidden;
        font-size: 1rem;
    }

    .price-btn:hover {
        color: #263953;
    }

    .price-btn.border-btn {
        border: 2px solid #263953;
        background: 0 0;
        color: #263953
    }

    .btn-hover {
        position: relative;
        overflow: hidden
    }

    .btn-hover::after {
        content: '';
        position: absolute;
        width: 0%;
        height: 0%;
        border-radius: 50%;
        background: rgba(0, 0, 0, .05);
        top: 50%;
        left: 50%;
        padding: 50%;
        z-index: -1;
        transition: all .3s ease-out 0s;
        transform: translate3d(-50%, -50%, 0) scale(0);
    }

    .btn-hover:hover::after {
        transform: translate3d(-50%, -50%, 0) scale(1.3)
    }

    .pricing .card-price {
        font-size: 2rem;
        margin: 0;
    }

    .pricing .card-price .price-decimal {
        font-size: 0.9rem;
        vertical-align: super;
    }

    .pricing ul li {
        margin-bottom: 0.5rem;
        list-style: none;
        padding-left: 0;
    }
</style>

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('user.subscription') }}">{{ __('Subscription') }}</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($message == 'payment_success')
    <div class="alert alert-success">
        {{ __('Thank you for your payment') }}
    </div>
@endif

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        @if ($message == 'created')
            {{ __('Subscription created.') }}
        @endif
        @if ($message == 'updated')
            {{ __('Updated') }}
        @endif
        @if ($message == 'deleted')
            {{ __('Deleted') }}
        @endif
        @if ($message == 'canceled')
            {{ __('You canceled your subscription') }}
        @endif
        @if ($message == 'resumed')
            {{ __('You resumed your subscription') }}
        @endif
        @if ($message == 'changed')
            {{ __('You subscription was changed') }}
        @endif
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger">
        @if ($message == 'exists')
            {{ __('Error. There is another subscription for this user. You can extend existing subscription or cancel the subscription to create another subscription.') }}
        @endif

        @if ($message == 'invalid_subscription')
            {{ __('Error. You can not cancel because you are not subscribed to this subscription plan.') }}
        @endif

        @if ($message == 'already_subscribed_to_this_plan')
            {{ __('Error. You are already subscribed to this plan. Please select another plan to upgrade or downgrade.') }}
        @endif

        @if ($message == 'subscription_canceled_on_grace_period')
            {{ __('Error. You have a canceled subscription. You must resume existing subscription before upgrading or downgrading to another subscription') }}
        @endif

    </div>
@endif

<div class="card">

    <div class="card-body">

        <div class="fs-6 fw-bold ">
            {{ __('Subscription status') }}:
            @if ($user->subscription() ?? null)
                @if ($subscription->stripe_status == 'active')
                    <span class="badge bg-success fs-6">{{ __('active') }}</span>
                @else
                    <span class="badge bg-warning fs-6">{{ $subscription->stripe_status }}</span>
                @endif

                @if ($subscription->ends_at)
                    <div class="alert alert-light fw-bold">
                        @if ($subscription->onGracePeriod() ?? false)
                            <div class="text-danger mb-2">
                                <i class="bi bi-exclamation-circle"></i> {{ __('Subscription was canceled and expire at') }}: {{ date_locale($subscription->ends_at) }}
                            </div>

                            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#resume-subscription" href="#">{{ __('Resume subscription') }}</a>
                            @include('user.subscription.modals.resume-subscription')
                        @else
                            <div class="text-danger"><i class="bi bi-info-circle"></i> {{ __('Subscription ends at') }} {{ date_locale($subscription->ends_at) }}</div>
                        @endif

                    </div>
                @else
                    @if ($next_billing_date ?? null)
                        <div class="mt-2">
                            {{ __('Next payment at') }}: <b>{{ $next_billing_date ?? null }}</b>
                        </div>
                    @endif
                @endif

                @if ($user->onTrial())
                    <div class="text-success mt-2">
                        {{ __('You are on the trial period.') }} {{ __('Trial ends at') }}: {{ date_locale($user->trialEndsAt(), 'datetime') }}
                    </div>
                @elseif ($user->hasExpiredTrial())
                    <div class="text-danger mt-2">
                        {{ __('Your trial period expired. You must update your subscription to continue using your website / workspace.') }}
                        <div class="text-muted small fw-normal">{{ __('Trial ended at') }}: {{ date_locale($user->trialEndsAt(), 'datetime') }}</div>
                    </div>
                @endif
            @else
                <span class="badge bg-warning fs-6">{{ __('no subscription') }}</span>
            @endif
        </div>


        @if ($user->subscription() ?? null)
            <div class="col-12">
                <div class="mt-3 mb-2">
                    <a target="_blank" href="{{ $portalSessionUrl ?? '#' }}" class="price-btn btn-hover text-uppercase btn-lg">{{ __('Go to billing portal to manage your subscription') }}</a>
                </div>
            </div>
        @endif



        @if ($count_user_sites == 0)
            <div class="alert alert-light text-danger fw-bold mb-3"><i class="bi bi-info-circle"></i> {{ __('Before creating a new subscription, you must have an active website / workspace.') }}
                <a href="{{ route('user.sites.index') }}">{{ __('Create website / workspace') }}</a>
            </div>
        @else
            @if ($user->subscription() ?? null)
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="fs-5 mb-3 text-center">
                            <div class="badge bg-warning fw-bold text-black">3 months free (save 25%) on yearly plan</div>
                        </div>
                    </div>
                </div>

                <script async src="https://js.stripe.com/v3/pricing-table.js"></script>
                <stripe-pricing-table client-reference-id="{{ $user->stripe_id }}" customer-session-client-secret="{{ $customerSession->client_secret }}" pricing-table-id="{{ config('app.stripe_pricing_table_id') }}"
                    publishable-key="{{ config('app.stripe_key') }}">
                </stripe-pricing-table>

                <div class="text-center text-muted">
                    <i class="bi bi-info-circle"></i> {{ __('All taxes are included in the price.') }}
                </div>
            @endif



            {{--
            <hr>
            @if ($subscription ?? null)
                @if (!$subscription->ends_at)
                    <a class="btn btn-danger float-start me-2" data-bs-toggle="modal" data-bs-target="#cancel-subscription" href="#">{{ __('Cancel subscription') }}</a>
                    @include('user.subscription.modals.cancel-subscription')
                @endif
            @endif
            --}}
        @endif

    </div>

</div>



{{--
        @if ($user->trial_ends_at)
            @if ($user_on_trial)
                <div class="alert alert-light fw-bold">
                    <div class="text-success"><i class="bi bi-info-circle"></i> {{ __('Trial ends at') }} {{ date_locale($user->trial_ends_at) }}</div>
                </div>
            @else
                <div class="alert alert-light fw-bold">
                    <div class="text-danger"><i class="bi bi-exclamation-triangle"></i> {{ __('Trial expired at') }} {{ date_locale($user->trial_ends_at) }}</div>
                </div>
            @endif
        @else
            @if ($user_subscribed_agency10)
                <div class="alert alert-light fw-bold">
                    <div class="text-success fs-5"> {{ __('Current plan') }}: AGENCY 10</div>
                    
                    @if ($subscription_canceled_on_grace_period)
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-triangle"></i> {{ __('Subscription was canceled and expire on') }}: @if ($next_billing_agency10){{ date_locale($next_billing_agency10) }}@endif </div>
                        <a class="btn btn-success" href="{{ route('central.user.subscription.resume', ['subscription' => 'agency10']) }}">{{ __('Resume subscription') }}</a>
                    @else
                        {{ __('Next billing date') }}: @if ($next_billing_agency10){{ date_locale($next_billing_agency10) }}@endif                        
                        <a class="btn btn-light btn-sm text-danger float-end ms-2 border-secondary" data-bs-toggle="modal" data-bs-target="#cancel_agency10" href="#">{{ __('Cancel subscription') }}</a>
                        @include('central.user.subscription.modals.cancel-agency10')
                    @endif
                </div>
            @elseif($user_subscribed_agency5)
                <div class="alert alert-light fw-bold">
                    <div class="text-success"><i class="bi bi-info-circle"></i> {{ __('Current plan') }}: AGENCY 5</div>

                    @if ($subscription_canceled_on_grace_period)
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-triangle"></i> {{ __('Subscription was canceled and expire on') }}: @if ($next_billing_agency5){{ date_locale($next_billing_agency5) }}@endif </div>
                        <a class="btn btn-success" href="{{ route('central.user.subscription.resume', ['subscription' => 'agency5']) }}">{{ __('Resume subscription') }}</a>
                    @else
                        {{ __('Next billing date') }}: @if ($next_billing_agency5){{ date_locale($next_billing_agency5) }}@endif                        
                        <a class="btn btn-light btn-sm text-danger float-end ms-2 border-secondary" data-bs-toggle="modal" data-bs-target="#cancel_agency5" href="#">{{ __('Cancel subscription') }}</a>
                        @include('central.user.subscription.modals.cancel-agency5')
                    @endif
                </div>
            @elseif($user_subscribed_starter)
                <div class="alert alert-light fw-bold">
                    <div class="text-success"><i class="bi bi-info-circle"></i> {{ __('Current plan') }}: STARTER</div>

                    @if ($subscription_canceled_on_grace_period)
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-triangle"></i> {{ __('Subscription was canceled and expire on') }}: @if ($next_billing_starter){{ date_locale($next_billing_starter) }}@endif </div>
                        <a class="btn btn-success" href="{{ route('central.user.subscription.resume', ['subscription' => 'starter']) }}">{{ __('Resume subscription') }}</a>
                    @else
                        {{ __('Next billing date') }}: @if ($next_billing_starter){{ date_locale($next_billing_starter) }}@endif                                                
                        <a class="btn btn-light btn-sm text-danger float-end ms-2 border-secondary" data-bs-toggle="modal" data-bs-target="#cancel_starter" href="#">{{ __('Cancel subscription') }}</a>
                        @include('central.user.subscription.modals.cancel-starter')
                    @endif
                </div>
            @endif
        @endif
        --}}
