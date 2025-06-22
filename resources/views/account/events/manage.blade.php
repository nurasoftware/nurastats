@if ($openmodal == 1)
    <script>
        $(document).ready(function() {
            $('#createSite').modal('show');
        });
    </script>
@endif

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('user.site.events', ['code' => $site->code]) }}">{{ __('Events') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Manage events') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>



<div class="card">

    <div class="card-header">

        <button data-bs-toggle="modal" data-bs-target="#createEvent" class="btn btn-gear float-end ms-2"><i class="bi bi-plus-circle"></i> {{ __('Add event') }}</button>
        @include('user.events.modals.create')

        <h4 class="card-title">{{ __('Events') }} </h4>

    </div>


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
                    {{ __('Error. There is another event with this label for this website.') }}
                @endif
            </div>
        @endif

        @if ($events->total() == 0)
            <div class="fw-bold text-danger mb-3">{{ __("You don't have any event added.") }}</div>
        @endif

        <div class="table-responsive-md">

            <table class="table table-bordered table-hover">

                @foreach ($events as $event)
                    <tr>
                        <td>
                            @if ($event->active == 0)
                                <div class="float-end ms-2 badge bg-warning fs-6 fw-normal">{{ __('Inactive') }}</div>
                            @else
                                <div class="float-end ms-2 badge bg-success fs-6 fw-normal">{{ __('Active') }}</div>
                            @endif

                            <div class="fw-bold fs-5">
                                {{ $event->label }}
                            </div>

                            @if ($event->description)
                                <div class="text-muted small">
                                    {{ $event->description }}
                                </div>
                            @endif

                            <div class="small text-muted">{{ __('Created at') }} {{ $event->created_at }}</div>
                        </td>


                        <td width="200">
                            <div class="d-grid gap-2">
                                <a href="{{ route('user.site.events', ['code' => $site->code, 'search_event' => $event->code]) }}" class="btn btn-primary mb-2"><i class="bi bi-graph-up"></i>
                                    {{ __('Event stats') }}</a>

                                <a href="{{ route('user.site.event.config', ['code' => $site->code, 'event_code' => $event->code]) }}" class="btn btn-primary"><i class="bi bi-gear"></i> {{ __('Event settings') }}</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        {{ $events->links() }}

    </div>
    <!-- end card-body -->

</div>
