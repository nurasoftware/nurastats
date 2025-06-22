<?php
debug_backtrace() || die('Direct access not permitted');
?>
<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="updateLabel_{{ $site->code }}" aria-hidden="true" id="updateSite_{{ $site->code }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('site.update', ['code' => $site->code]) }}" method="post">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="updateLabel_{{ $site->code }}">{{ __('Update') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{ __('Label') }}</label>
                        <input class="form-control" name="label" type="text" maxlength="20" required value="{{ $site->label }}" />
                        <div class="form-text text-muted">{{ __('Maximum 20 characters') }}</div>
                    </div>

                    <div class="form-group">
                        <label>{{ __('URL') }}</label>
                        <input type="text" class="form-control" aria-describedby="addonUrl_{{ $site->code }}" value="{{ $site->url }}" readonly disabled>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Timezone') }}</label>
                        <select name="timezone" class="selectpicker" data-live-search="true" title="{{ __('Select') }}" required>
                            @foreach ($timezones_array as $key => $timezone)
                                <option @if ($key == $site->timezone) selected @endif value="{{ $key }}">{{ $timezone }}</option>
                            @endforeach
                        </select>
                        <div class="text-muted small mt-1">{!! __('Choose the timezone of the reporting for this website') !!}</div>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="customSwitchSubdomains" name="allow_subdomains" @if ($site->allow_subdomains == 1) checked @endif>
                            <label class="form-check-label" for="customSwitchSubdomains">{{ __('Allow subdomains tracking') }}</label>
                        </div>
                        <div class="text-muted small">
                            {{ __('If you have a website with subdomains, you can use a single analytics code to track visitors from main domain and subdomains. If you disable this settings, the analytics code will collect data only from the url defined above.') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="customSwitchFav" name="favourite" @if ($site->favourite == 1) checked @endif>
                            <label class="form-check-label" for="customSwitchFav">{{ __('Favourite') }}</label>
                        </div>
                        <div class="text-muted small">{{ __('Favourite websites will be displayed first.') }}</div>
                    </div>


                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="customSwitchActive" name="active" @if ($site->active == 1) checked @endif>
                            <label class="form-check-label" for="customSwitchActive">{{ __('Active website') }}</label>
                        </div>
                        <div class="text-muted small">{{ __('Only active websites will collect data from visitors.') }}</div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </div>

            </form>

        </div>
    </div>
</div>
