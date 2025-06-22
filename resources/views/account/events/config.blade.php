<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.sites.index') }}">{{ __('Websites') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.site.show', ['code' => $site->code]) }}">{{ $site->label }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.site.events', ['code' => $site->code]) }}">{{ __('Events') }}</a></li>
                    <li class="breadcrumb-item active">{{ $event->label }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="row">

    <div class="col-md-8 col-12">

        <div class="card">

            <div class="card-body">

                <button data-bs-toggle="modal" data-bs-target="#updateEvent_{{ $event->code }}" class="btn btn-primary btn-sm ms-2 float-end">{{ __('Update') }}</button>
                @include('user.events.modals.update')

                <div class="fw-bold fs-5 mb-2">{{ $event->label }}</div>

                @if ($event->description)
                    <div class="text-muted small mb-2">
                        {{ $event->description }}
                    </div>
                @endif

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
                            {{ __('Error. There is another event with this label.') }}
                        @endif
                    </div>
                @endif

                <hr>

                <div class="fw-bold fs-5">{{ __('Event code') }}</div>

                @if ($event->type == 'click')
                    <div class="mb-2">
                        <i class="bi bi-info-circle"></i>
                        {{ __('To track this event, you must add the following script in your website code, somewhere below the link that you want to track (typically just above the </body> element).') }}
                    </div>

                    <div class="mb-3">
                        {{ __('IMPORTANT. You must change the ID value ("contact-us-link" in the example code below) to the ID you use in your website code') }}                        
                    </div>

                    <textarea class="form-control" rows="7"><script>
                        window.addEventListener('load', (event) => {
                            document.getElementById('contact-us-link').addEventListener('click', () => {
                                clevadaTrackEvent('{{ $event->code }}');
                            });
                        });
                    </script></textarea>
                    <button id="buttonCopy" class="btn btn-sm btn-secondary mt-2">{{ __('Copy code') }}</button>
                    <div id="copied" class="text-success mt-2 fw-bold d-none">{{ __('Event code copied. You can paste it in your website') }}</div>
                    <script>
                        $("#buttonCopy").click(function() {
                            $("textarea").select();
                            document.execCommand('copy');
                            $("div#copied").removeClass("d-none");
                            $("div#copied").addClass("d-block");
                        });
                    </script>
                @endif


                @if ($event->type == 'form_submit')
                <div class="mb-2">
                    <i class="bi bi-info-circle"></i>
                    {{ __('To track this event, you must add the following script in your website code, after/below the form.') }}
                </div>

                <div class="mb-3">
                    {{ __("IMPORTANT. You must change the form ID value ('form-ID' in the example code below) to the ID you use in your form code. If your form don't have an ID, you must add an ID.") }}
                </div>


                <textarea class="form-control" rows="7"><script>
                    window.addEventListener('load', (event) => {
                        document.getElementById('form-ID').addEventListener('submit', () => {
                            clevadaTrackEvent('{{ $event->code }}');
                        });
                    });
                </script></textarea>
                <button id="buttonCopy" class="btn btn-sm btn-secondary mt-2">{{ __('Copy code') }}</button>
                <div id="copied" class="text-success mt-2 fw-bold d-none">{{ __('Event code copied. You can paste it in your website') }}</div>
                <script>
                    $("#buttonCopy").click(function() {
                        $("textarea").select();
                        document.execCommand('copy');
                        $("div#copied").removeClass("d-none");
                        $("div#copied").addClass("d-block");
                    });
                </script>
            @endif

            </div>
            <!-- end card-body -->

        </div>

    </div>


    <div class="col-md-4 col-12">

        <div class="card">

            <div class="card-body">


                <b>{{ __('Event type') }}:</b>
                @if ($event->type == 'link')
                    {{ __('Link clicks') }}
                @elseif($event->type == 'external_link')
                    {{ __('External link clicks') }}
                @elseif($event->type == 'error_page')
                    {{ __('Track 404/error pages') }}
                @elseif($event->type == 'conversion')
                    {{ __('Conversions') }}
                @elseif($event->type == 'form_submit')
                    {{ __('Form submissions') }}
                @else
                    {{ $event->type }}
                @endif

                <div class="small text-muted mt-2 mb-4">{{ __('Created at') }} {{ $event->created_at }}</div>


                <a href="#" data-bs-toggle="modal" data-bs-target=".confirm-{{ $event->code }}" class="btn btn-danger btn-sm">{{ __('Delete event') }}</a>
                <div class="modal fade confirm-{{ $event->code }}" tabindex="-1" role="dialog" aria-labelledby="ConfirmDeleteLabel-{{ $event->code }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ConfirmDeleteLabel-{{ $site->code }}">{{ __('Confirm delete') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{ __('Are you sure you want to delete this event?') }}

                                <div class="mt-2 fw-bold">
                                    <i class="bi bi-info-circle"></i> {{ __('Event data (statistics) will be permanently deleted.') }}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form method="POST" action="{{ route('user.site.event.delete', ['code' => $site->code, 'event_code' => $event->code]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    <button type="submit" class="btn btn-danger">{{ __('Delete event') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
