<div class="modal fade" id="cancel-subscription" tabindex="-1" role="dialog" aria-labelledby="ConfirmCancelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <h5 class="modal-title" id="ConfirmCancelLabel">{{ __('Cancel subscription') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="fs-5 mb-2 fw-normal">{{ __('Are you sure you want to cancel this subscription?') }}</div>

                <div class="text-muted fw-bold">
                    {{--
                    <i class="bi bi-info-circle"></i> {{ __('Subscription will end on') }} @if ($next_billing_starter)<b>{{ date_locale($next_billing_starter) }}</b>@endif
                    <div class="mb-2"></div>
                    --}}

                    {{ __('Your subscription will continue to be active until the end of the billing cycle.') }}

                    <div class="mt-2 fw-bold text-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ __('Your website / workspace will be set to inactive after the subscription ends. You have 30 days from the end of your subscription date to create another subscription, otherwise, the website and workspace data will be permanently deleted.') }}
                    </div>                   
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('central.user.subscription.cancel') }}">
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>

                    <button type="submit" class="btn btn-danger">{{ __('Cancel subscription') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
