<?php
debug_backtrace() || die('Direct access not permitted');
?>
<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="updateEventLabel_{{ $event->code }}" aria-hidden="true" id="updateEvent_{{ $event->code }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('user.site.event.update', ['code' => $site->code, 'event_code' => $event->code]) }}" method="post">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="updateEventLabel_{{ $event->code }}">{{ __('Update') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{ __('Label') }}</label>
                        <input class="form-control" name="label" type="text" maxlength="25" required value="{{ $event->label }}" />
                        <div class="form-text text-muted">{{ __('A short name to identify the event. Maximum 25 characters') }}</div>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Description') }} ({{ __('optional') }})</label>
                        <textarea class="form-control" name="description" rows="2">{{ $event->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="customSwitchActive" name="active" @if ($event->active == 1) checked @endif>
                            <label class="form-check-label" for="customSwitchActive">{{ __('Active event') }}</label>
                        </div>
                        <div class="text-muted small">{{ __('Only active everts will collect data from websites.') }}</div>
                    </div>

                    <hr>

                    <div class="mt-1">
                        <button type="submit" class="btn btn-primary submitBtn">{{ __('Update') }}</button>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>
