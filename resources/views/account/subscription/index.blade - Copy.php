<script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>

<style>
    section.pricing {
        margin-bottom: 20px;
    }

    .pricing .card {
        border: none;
        border-radius: 1rem;
        transition: all 0.2s;
        box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
    }

    .pricing hr {
        margin: 1.5rem 0;
    }

    .pricing .card-title {
        margin: 0.5rem 0;
        font-size: 0.9rem;
        letter-spacing: .1rem;
        font-weight: bold;
    }

    .pricing .card-price {
        font-size: 2rem;
        margin: 0;
    }

    .pricing .card-price .period {
        font-size: 0.85rem;
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

    .pricing .text-muted {
        opacity: 0.7;
    }

    .pricing .btn {
        font-size: 90%;
        border-radius: 0.5rem;
        letter-spacing: .1rem;
        font-weight: bold;
        padding: 1rem;
        color: white;
    }

    .pricing .btn:hover {
        color: white;
    }
</style>


<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('central.user.subscription') }}">{{ __('Subscription') }}</a></li>
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
            {{ __('You canceled your subscription.') }}
        @endif
        @if ($message == 'resumed')
            {{ __('You resumed your subscription.') }}
        @endif
        @if ($message == 'changed')
            {{ __('You subscription was changed.') }}
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

        <div class="fs-6 fw-bold mb-3">
            {{ __('Subscription status') }}:
            @if ($user->subscription() ?? null)
                @if ($subscription->status == 'active')
                    <span class="badge bg-success fs-6">{{ __('active') }}</span>
                @else
                    <span class="badge bg-warning fs-6">{{ $subscription->status }}</span>
                @endif

                @if ($subscription->ends_at)
                    <div class="alert alert-light fw-bold">
                        @if ($subscription->onGracePeriod() ?? false)
                            <div class="text-danger mb-2">
                                <i class="bi bi-exclamation-circle"></i> {{ __('Subscription was canceled and expire at') }}: {{ date_locale($subscription->ends_at) }}
                            </div>

                            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#resume-subscription" href="#">{{ __('Resume subscription') }}</a>
                            @include('central.user.subscription.modals.resume-subscription')
                        @else
                            <div class="text-danger"><i class="bi bi-info-circle"></i> {{ __('Subscription ends at') }} {{ date_locale($subscription->ends_at) }}</div>
                        @endif

                    </div>
                @else
                    <div class="mt-2">
                        {{ __('Next payment') }}: <b>{{ $nextPayment->amount() }}</b> {{ __('due on') }} <b>{{ date_locale($nextPayment->date()) }}</b>
                    </div>
                @endif
            @else
                <span class="badge bg-warning fs-6">{{ __('no subscription') }}</span>

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
            @endif
        </div>


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


<div class="card">

    <div class="card-body">

        @if ($count_user_tenants == 0)
            <div class="alert alert-light text-danger fw-bold mb-3"><i class="bi bi-info-circle"></i> {{ __('Before creating a new subscription, you must have an active website / workspace.') }}
                <a href="{{ route('central.user.tenant') }}">{{ __('Create website / workspace') }}</a>
            </div>
        @else
            <div class="fs-6 fw-bold mb-3">{{ __('Upgrade plan') }}:</div>

            <div class="row">
                <div class="col-md-7 col-lg-8 col-xl-9 col-xxl-10">
                    <div class="fs-5 mt-4 text-center">
                        <div id="pricing_toggle">
                            <input class="form-check-input" type="radio" name="plan" value="month" id="month" onclick="getPrices('month')"> <label class="form-check-label" for="month">Monthly</label>
                            <input class="form-check-input ms-4" type="radio" name="plan" value="year" id="year" onclick="getPrices('year')" checked> <label class="form-check-label" for="year">Yearly
                                <span class="badge bg-success">3 months free (save 25%)</span></label>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-lg-4 col-xl-3 col-xxl-2">
                    <div class="country-selector">
                        <label>{{ __('Country / currency') }}</label>
                        <select class="form-select" name="country" id="country" autocomplete="off">
                            <option value="US">🇺🇸 United States</option>
                            <option value="GB">🇬🇧 United Kingdom</option>
                            <option value="ES">🇪🇸 Spain</option>
                            <option value="IN">🇮🇳 India</option>
                            <option value="US">🌍 Other</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="pricing clearfix mt-4">
                <div class="row">
                    <!-- Basic Tier -->
                    <div class="col-lg-6">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Website</h5>
                                <h6 class="card-price text-center">
                                    <p id="basic-price"></p>
                                </h6>

                                <ul class="fa-ul">
                                    <li><i class="bi bi-check"></i> <strong>Advanced Website Builder</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>Unlimited Pages and Posts</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>Contact Page and Contact Form</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>Community Forum</strong></li>
                                    <li class="text-muted"><i class="bi bi-x"></i> Bookings System</li>
                                    <li class="text-muted"><i class="bi bi-x"></i> Knowledge Base</li>
                                    <li class="text-muted"><i class="bi bi-x"></i> Support Tickets</li>

                                    <li><i class="bi bi-check"></i> <strong>1 admin account</strong></li>
                                    <li class="text-muted"><i class="bi bi-x"></i> internal accounts</li>
                                    <li><i class="bi bi-check"></i> <strong>5 GB Storage</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>20 GB Traffic</strong></li>
                                </ul>


                                <form method="POST" action="{{ route('central.user.subscription.store') }}">
                                    @csrf
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg" id="btnBasic">{{ __('Select this plan') }}</button>
                                    </div>
                                    <input type="hidden" id="checkoutPriceBasic" name="price" value="">
                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- Plus Tier -->
                    <div class="col-lg-6">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Website Plus</h5>
                                <h6 class="card-price text-center">
                                    <p id="plus-price"></p>
                                </h6>

                                <ul class="fa-ul">
                                    <li><i class="bi bi-check"></i> <strong>Advanced Website Builder</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>Unlimited Pages and Posts</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>Contact Page and Contact Form</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>Community Forum</strong></li>
                                    <li class="text-muted"><i class="bi bi-check"></i> <strong>Bookings System (Soon)</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>Knowledge Base</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>Support Tickets</strong></li>

                                    <li><i class="bi bi-check"></i> <strong>3 admin accounts</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>5 internal accounts</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>25 GB Storage</strong></li>
                                    <li><i class="bi bi-check"></i> <strong>Unlimited Traffic</strong></li>
                                </ul>

                                <form method="POST" action="{{ route('central.user.subscription.store') }}">
                                    @csrf
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg" id="btnPlus">{{ __('Select this plan') }}</button>
                                    </div>
                                    <input type="hidden" id="checkoutPricePlus" name="price" value="">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            @if ($subscription ?? null)
                @if (!$subscription->ends_at)
                    <a class="btn btn-danger float-start me-2" data-bs-toggle="modal" data-bs-target="#cancel-subscription" href="#">{{ __('Cancel subscription') }}</a>
                    @include('central.user.subscription.modals.cancel-subscription')
                @endif
            @endif
        @endif
    </div>
    <!-- end card-body -->

</div>


<script type="text/javascript">
    Paddle.Environment.set("sandbox");
    Paddle.Setup({
        token: '{{ config('clevada.paddle_client_side_token') }}',
    });

    // define products and prices
    var websiteBasicProduct = '{{ config('clevada.product_website_basic') }}';
    var websitePlusProduct = '{{ config('clevada.product_website_plus') }}';

    var monthItems = [{
            quantity: 1,
            priceId: '{{ config('clevada.price_website_basic_monthly') }}',
        },
        {
            quantity: 1,
            priceId: '{{ config('clevada.price_website_plus_monthly') }}',
        }
    ];
    var yearItems = [{
            quantity: 1,
            priceId: '{{ config('clevada.price_website_basic_yearly') }}',
        },
        {
            quantity: 1,
            priceId: '{{ config('clevada.price_website_plus_yearly') }}',
        }
    ];

    // DOM queries
    var basicPriceLabel = document.getElementById("basic-price");
    var plusPriceLabel = document.getElementById("plus-price");

    // set initial billing cycle
    var billingCycle = 'year';

    // set initial country
    var billingCountry = 'US';

    // choose country
    var dropdown = document.getElementById("country");
    dropdown.addEventListener("change", function() {
        billingCountry = dropdown.value;
        var billingCycle = document.querySelector('input[name="plan"]:checked').value;
        getPrices(billingCycle);
    });

    var user_subscribed_price_id = "{{ $user_subscribed_price_id }}";

    // get prices
    function getPrices(cycle) {
        if (cycle === 'month') {
            var billingCycle = cycle;
            var itemsList = monthItems;
        } else if (cycle === 'year') {
            var billingCycle = cycle;
            var itemsList = yearItems;
        }

        var request = {
            items: itemsList,
            address: {
                countryCode: billingCountry
            }
        }

        Paddle.PricePreview(request)
            .then((result) => {
                //console.log(result);

                var items = result.data.details.lineItems;
                for (item of items) {
                    if (item.product.id === websiteBasicProduct) {
                        //basicPriceLabel.innerHTML = item.formattedTotals.subtotal
                        basicPriceLabel.innerHTML = item.formattedTotals.total
                        //console.log('basic ' + item.formattedTotals.subtotal)
                        document.getElementById('checkoutPriceBasic').value = item.price.id
                        //alert(item.price.id)
                        var buttonBasic = document.getElementById('btnBasic')
                        if (user_subscribed_price_id == item.price.id) {
                            buttonBasic.innerText = buttonBasic.textContent = 'Current plan'
                            buttonBasic.classList.remove('btn-primary')
                            buttonBasic.classList.add('btn-secondary')
                            buttonBasic.disabled = true;
                        } else {
                            buttonBasic.innerText = buttonBasic.textContent = 'Select this plan'
                            buttonBasic.classList.add('btn-primary')
                            buttonBasic.classList.remove('btn-secondary')
                            buttonBasic.disabled = false;
                        }
                    } else if (item.product.id === websitePlusProduct) {
                        //plusPriceLabel.innerHTML = item.formattedTotals.subtotal
                        plusPriceLabel.innerHTML = item.formattedTotals.total
                        document.getElementById('checkoutPricePlus').value = item.price.id
                        //console.log('plus ' + item.formattedTotals.subtotal)
                        //alert(item.price.id)
                        var buttonPlus = document.getElementById('btnPlus')
                        if (user_subscribed_price_id == item.price.id) {
                            buttonPlus.innerText = buttonPlus.textContent = 'Current plan'
                            buttonPlus.classList.remove('btn-primary')
                            buttonPlus.classList.add('btn-secondary')
                            buttonPlus.disabled = true;
                        } else {
                            buttonPlus.innerText = buttonPlus.textContent = 'Select this plan'
                            buttonPlus.classList.add('btn-primary')
                            buttonPlus.classList.remove('btn-secondary')
                            buttonPlus.disabled = false;
                        }
                    }
                }
            })
            .catch((error) => {
                //console.error(error);
            });
    }
</script>
