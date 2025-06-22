<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Events') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>



<div class="card">

    <div class="card-header">

        <a class="btn btn-gear float-end ms-2" href="{{ route('user.site.events.manage', ['code' => $site->code]) }}"><i class="bi bi-gear"></i> {{ __('Manage events') }}</a>

        <h4 class="card-title">{{ __('Events') }} </h4>

        <div class="clearfix"></div>
        
        <section class="mt-2">
            <form action="{{ route('user.site.events', ['code' => $site->code]) }}" method="get" class="row row-cols-lg-auto g-3 align-items-center">

                <div class="col-12 ps-0">
                    <select name="search_event" class="form-select @if ($search_event ?? null) is-valid @endif">
                        <option selected="selected" value="">- {{ __('All events') }} -</option>
                        @foreach ($events as $event)
                            <option @if ($search_event == $event->code) selected @endif value="{{ $event->code }}"> {{ $event->label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-12">
                    <button class="btn btn-secondary me-2" type="submit"><i class="bi bi-check2"></i> {{ __('Apply') }}</button>
                    <a title="{{ __('Reset') }}" class="btn btn-light" href="{{ route('user.site.events', ['code' => $site->code]) }}"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>

            </form>
        </section>

        <hr>
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


        @if (count($events) == 0)
            <div class="fw-bold text-danger mb-3">{{ __("You don't have any event added.") }}</div>
        @endif

        <div class="table-responsive-md">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Event details') }}</th>
                        <th scope="col">{{ __('Action details') }}</th>
                        <th scope="col">{{ __('Visitor details') }}</th>
                        <th scope="col">{{ __('Page details') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($actions as $action)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $action->event->label }}</div>

                                <div class="badge bg-light text-dark">
                                    @if ($action->event->type == 'link')
                                        {{ __('Link clicks') }}
                                    @elseif($action->event->type == 'external_link')
                                        {{ __('External link clicks') }}
                                    @elseif($action->event->type == 'error_page')
                                        {{ __('Track 404/error pages') }}
                                    @elseif($action->event->type == 'conversion')
                                        {{ __('Conversions') }}
                                    @elseif($action->event->type == 'form_submit')
                                        {{ __('Form submissions') }}
                                    @else
                                        {{ $action->event->type }}
                                    @endif
                                </div>
                            </td>


                            <td>
                                <div class="mb-0 fw-bold">{{ $action->time_diff_human }}</div>

                                <div class="mb-2 small fw-normal">{{ date_locale($action->created_at, 'H d Y, H:i:s') }}</div>

                                <div class="text-clamp-1">
                                    <a target="_blank" class="small" title="{{ $action->page->domain }}/{{ $action->page->page }}"
                                        href="https://{{ $action->page->domain }}{{ $action->page->page }}">{{ $action->page->title }}</a>
                                    <div class="small text-muted fw-normal mb-2">
                                        {{ $action->page->domain }}</b>{{ $action->page->page }}
                                    </div>

                            </td>



                            <td>
                                <div class="float-start me-2"><img style="width: 22px; height: 22px;" src="{{ config('app.cdn') }}/assets//img/flags/circle/{{ strtolower($action->visitor->geo_cc) }}.svg" alt="{{ $action->visitor->geo_country }}">
                                </div>
                                {{ $action->visitor->geo_city }}, {{ $action->visitor->geo_country }} <i class="bi bi-dot"></i> <span class="text-muted small fw-normal">{{ $action->visitor->ip }}</span>

                                <div class="clearfix"></div>

                                <div class="fw-bold line-clamp-1">
                                    @if ($action->referrer)
                                        {{ __('Referrer') }}: <span class="fw-normal">{{ $action->referrer }}</span>
                                    @else
                                        {{ __('Direct visit') }}
                                    @endif
                                </div>
                            </td>

                            <td>
                                <i class="bi bi-graph-up"></i> <a href="{{ route('user.site.page_stats', ['code' => $site->code, 'hash' => $action->page->hash]) }}">{{ __('Page history') }}</a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $actions->appends(['search_event' => $search_event])->links() }}


    </div>
    <!-- end card-body -->

</div>
