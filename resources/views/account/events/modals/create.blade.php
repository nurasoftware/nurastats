<?php
debug_backtrace() || die('Direct access not permitted');
?>
<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="createEventLabel" aria-hidden="true" id="createEvent">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="post" action="{{ route('user.site.events', ['code' => $site->code]) }}" id="createEventForm">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="createEventLabel">{{ __('Add event') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Event type') }}</label>
                                <select name="type" class="form-select" required>
                                    <option value="">-- {{ __('select') }} --</option>
                                    <option value="link">{{ __('Link clicks') }}</option>
                                    <option value="external_link">{{ __('External link clicks') }}</option>
                                    <option value="error_page">{{ __('Track 404/error pages') }}</option>
                                    <option value="conversion">{{ __('Conversions') }}</option>
                                    <option value="form_submit">{{ __('Form submissions') }}</option>
                                </select>
                            </div>
                        </div>                      
                    </div>

                    <div class="form-group">
                        <label>{{ __('Label') }}</label>
                        <input class="form-control" name="label" type="text" maxlength="25" required />
                        <div class="form-text text-muted">{{ __('A short name to identify the event. Maximum 25 characters') }}</div>
                    </div>
                   
                    <div class="form-group">
                        <label>{{ __('Desctiption') }} ({{ __('optional') }})</label>
                        <textarea class="form-control" name="description" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="customSwitchActive" name="active" checked>
                            <label class="form-check-label" for="customSwitchActive">{{ __('Active event') }}</label>
                        </div>
                        <div class="text-muted small">{{ __('Only active everts will collect data from websites.') }}</div>
                    </div>

                    <hr>

                    <div class="mt-1">
                        <button type="submit" class="btn btn-primary submitBtn">{{ __('Add event') }}</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
