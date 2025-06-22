<?php
debug_backtrace() || die('Direct access not permitted');
?>
<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="createLabel" aria-hidden="true" id="createSite">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="post" action="{{ route('sites.index') }}" id="createSiteForm">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="createLabel">{{ __('Add website') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{ __('Label') }}</label>
                        <input class="form-control" name="label" type="text" maxlength="25" required />
                        <div class="form-text text-muted">{{ __('A short title to identify the website.') }}</div>
                    </div>

                    <div class="form-group">
                        <label>{{ __('URL') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" id="addonUrl">https://</span>
                            <input type="text" class="form-control" aria-describedby="addonUrl" name="url" id="domain" required>
                        </div>
                        <div class="text-muted small mt-1">{!! __('Without "http" or "https"') !!}</div>
                    </div>

                    <script>
                        $('#domain').keypress(function(e) {
                            var regex = new RegExp("^[a-zA-Z0-9-.]+$");
                            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                            if (regex.test(str)) {
                                return true;
                            }
                            e.preventDefault();
                            return false;
                        });
                    </script>

                    <div class="form-group">
                        <label>{{ __('Timezone') }}</label>
                        <select name="timezone" class="selectpicker" data-live-search="true" title="{{ __('Select') }}" required>
                            @foreach ($timezones_array as $key => $timezone)
                                <option value="{{ $key }}">{{ $timezone }}</option>
                            @endforeach
                        </select>
                        <div class="text-muted small mt-1">{!! __('Choose the timezone of the reporting for this website') !!}</div>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="customSwitchSubdomains" name="allow_subdomains" checked>
                            <label class="form-check-label" for="customSwitchSubdomains">{{ __('Allow subdomains tracking') }}</label>
                        </div>
                        <div class="text-muted small">
                            {{ __('If you have a website with subdomains, you can use a single analytics code to track visitors from main domain and subdomains. If you disable this settings, the analytics code will collect data only from the url defined above.') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="customSwitchActive" name="active" checked>
                            <label class="form-check-label" for="customSwitchActive">{{ __('Active website') }}</label>
                        </div>
                        <div class="text-muted small">{{ __('Only active websites will collect data from visitors.') }}</div>
                    </div>

                    <hr>

                    <div class="mt-1">
                        <button type="submit" class="btn btn-primary submitBtn">{{ __('Add website') }}</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
