<?php
debug_backtrace() || die('Direct access not permitted');
?>
<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="createLabel" aria-hidden="true" id="createSubscription">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <form method="post">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="createLabel">{{ __('Create subscription') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-light">
                        <i class="bi bi-info-circle"></i> <b>{{ __('You have a trial period to test the product. No payment details are required in trial period. There are no obligations at the end of the trial.') }}</b>
                        <hr>
                        {{ __(
                            "If you decide to continue using the product aftre the trial period, you will be prompted to input your payment details. If you don't want to continue after the trial period, the website created in trial mode will be automatically deleted after 30 days. You can resume or create a new subscription anytime.",
                        ) }}
                    </div>                    

                    <button type="submit" class="btn btn-primary">{{ __('Start trial period to create a website') }}</button>

                    <div class="small text-muted mt-3 mb-3">
                        {{ __('You have 7 days trial period to test the product for free, without any obligaitons. If you need more trial days for testing, you can open a support ticket to extend the trial for you.') }}
                    </div>

                    <div class="modal-footer">
                        <form method="POST">
                            {{ csrf_field() }}      
                            <input type="hidden" name="plan" id="plan">                      
                            <button type="submit" class="btn btn-danger">{{ __('Upgrade subscription') }}</button>
                        </form>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>
