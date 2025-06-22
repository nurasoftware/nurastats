<div class="modal fade" id="resume-subscription" tabindex="-1" role="dialog" aria-labelledby="ConfirmResumeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-start">
            <div class="modal-header">
                <h5 class="modal-title" id="ConfirmResumeLabel">{{ __('Resume subscription') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="fs-5 mb-2 fw-normal">{{ __('Are you sure you want to resume this canceled subscription?') }}</div>

                <div class="fw-bold">
                    {{--
                    <i class="bi bi-info-circle"></i> {{ __('Subscription will end on') }} @if ($next_billing_starter)<b>{{ date_locale($next_billing_starter) }}</b>@endif
                    <div class="mb-2"></div>
                    --}}

                    {{ __('Your subscription will be active again.') }}
                                   
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('user.subscription.resume') }}">
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>

                    <button type="submit" class="btn btn-success">{{ __('Resume subscription') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
