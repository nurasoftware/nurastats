<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('sites.index') }}">{{ __('Websites') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('site.show', ['code' => $site->code]) }}">{{ $site->label }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Website settings') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="row">

    <div class="col-md-8 col-12">

        <div class="card">

            <div class="card-body">

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
                            {{ __('Created') }}
                        @endif
                        @if ($message == 'updated')
                            {{ __('Updated') }}
                        @endif
                        @if ($message == 'deleted')
                            {{ __('Deleted') }}
                        @endif
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        @if ($message == 'duplicate_label')
                            {{ __('Error. There is another item with this label.') }}
                        @endif

                        @if ($message == 'wrong_password')
                            {{ __('Error. Wrong password.') }}
                        @endif
                    </div>
                @endif

                @if ($site->favourite == 1)
                    <div class="float-end ms-2"><i class="bi bi-star-fill text-warning"></i></div>
                @endif

                <div class="fw-bold fs-5 mb-2">{{ $site->label }}</div>

                <div class="small text-muted mb-2">
                    {{ __('Created at') }}: {{ \Carbon\Carbon::parse($site->created_at)->format('M d Y, H:i')}}
                </div>

                <div class="">
                    {{ __('Website URL') }}: <a target="_blank" href="https://{{ $site->url }}"><b>https://{{ $site->url }}</b></a>
                </div>

                <hr>


                <div class="fw-bold fs-5">{{ __('Analytics code') }}</div>
                <textarea class="form-control"><script async src="{{ config('nurastats.analytics_js_url') }}/analytics.js" data-site="{{ $site->code }}"></script></textarea>
                <button id="buttonCopy" class="btn btn-sm btn-secondary mt-2">{{ __('Copy code') }}</button>
                <div id="copied" class="text-success mt-2 fw-bold d-none">{{ __('Analytics code copied. You can paste it in your website') }}</div>
                <script>
                    $("#buttonCopy").click(function() {
                        $("textarea").select();
                        document.execCommand('copy');
                        $("div#copied").removeClass("d-none");
                        $("div#copied").addClass("d-block");
                    });
                </script>

            </div>
            <!-- end card-body -->

        </div>

    </div>


    <div class="col-md-4 col-12">

        <div class="card">

            <div class="card-body">

                <button data-bs-toggle="modal" data-bs-target="#updateSite_{{ $site->code }}" class="btn btn-primary ms-2 float-end">{{ __('Update settings') }}</button>
                @include('account.sites.modals.update')

                <div class="fw-bold fs-5 mb-2">{{ __('Settings') }}</div>

                <div class="mb-2">
                    {{ __('Timezone') }}: <b>{{ $site->timezone }}</b>
                </div>

                <div class="mb-2">
                    {{ __('Status') }}:
                    @if ($site->active == 0)
                        <span class="fw-bold text-danger">{{ __('Inactive') }}</span>
                    @else
                        <span class="fw-bold text-success">{{ __('Active') }}</span>
                    @endif
                </div>

                <div class="mb-2">
                    {{ __('Allow subdomains tracking') }}:
                    @if ($site->allow_subdomains == 0)
                        <span class="fw-bold text-danger mb-1">{{ __('No') }}</span>
                    @else
                        <span class="fw-bold text-success">{{ __('Yes') }}</span>
                    @endif
                </div>

                <hr>

                <a href="#" data-bs-toggle="modal" data-bs-target=".confirm-{{ $site->code }}" class="btn btn-danger btn-sm">{{ __('Delete website') }}</a>
                <div class="modal fade confirm-{{ $site->code }}" tabindex="-1" role="dialog" aria-labelledby="ConfirmDeleteLabel-{{ $site->code }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('site.delete', ['code' => $site->code]) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <div class="modal-header">
                                    <h5 class="modal-title" id="ConfirmDeleteLabel-{{ $site->code }}">{{ __('Confirm delete') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="fw-bold mb-3">https://{{ $site->url }}</div>

                                    {{ __('Are you sure you want to delete this site?') }}

                                    <div class="mt-2 fw-bold text-danger">
                                        <i class="bi bi-info-circle"></i> {{ __('All data (statistics, page views, events, campaigns...) will be permanently deleted.') }}
                                    </div>

                                    <div class="form-group mt-4 mb-3">
                                        <div>{{ __('Input your account password to delete this website') }}</div>
                                        <input type="password" name="verify_password" value="" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    <button type="submit" class="btn btn-danger">{{ __('Yes. Delete website') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
