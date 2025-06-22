<div class="modal fade" id="cancel_starter" tabindex="-1" role="dialog" aria-labelledby="ConfirmCancelStarterLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-start">
            <div class="modal-header">
                <h5 class="modal-title" id="ConfirmCancelStarterLabel">{{ __('Cancel subscription') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="fs-5 mb-2 fw-normal">{{ __('Are you sure you want to cancel this subscription?') }}</div>

                <div class="text-muted fw-bold">
                    <i class="bi bi-info-circle"></i> {{ __('Subscription will end on') }} @if ($next_billing_starter)<b>{{ date_locale($next_billing_starter) }}</b>@endif
                    <div class="mb-2"></div>

                    {{ __('Your subscription will continue to be active until the end of the billing cycle.') }}               

                    <div class="mt-2 fw-bold text-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ __('Your websites will be set to inactive after the subscription ends. You have 15 days from the end of your subscription date to resume or create another subscription, otherwise, the websites will be permanently deleted.') }}
                    </div>
                    <div class="mt-2 fw-normal">
                        {{ __('You can resume your subscription until the expiration date or create another subscription after your subscription expires.') }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('central.user.subscription.cancel') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="subscription" value="starter">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>

                    <button type="submit" class="btn btn-danger">{{ __('Cancel subscription') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
