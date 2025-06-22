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
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Websites') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-header">

        <button data-bs-toggle="modal" data-bs-target="#createSite" class="btn btn-gear btn-lg float-end ms-2"><i class="bi bi-plus-circle"></i> {{ __('Add website') }}</button>
        @include('account.sites.modals.create')

        <h4 class="card-title">{{ __('Websites') }} </h4>

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

        @if (Request::get('subscription') == 'changed')
            <div class="fw-bold text-success mb-3"><i class="bi bi-info-circle"></i> {{ __('Subscription updated. Thank you.') }}</div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger">
                @if ($message == 'duplicate_label')
                    {{ __('Error. There is another site with this label.') }}
                @endif
            </div>
        @endif

        @if ($sites->total() == 0)
            <div class="fw-bold text-danger mb-3">{{ __("You don't have any website added.") }}</div>
        @endif

        <div class="table-responsive-md">

            <table class="table table-bordered table-hover">

                @foreach ($sites as $site)
                    <tr>
                        <td>
                            @if ($site->active == 0)
                                <div class="float-end ms-2 badge bg-danger fs-6 fw-normal">{{ __('Inactive') }}</div>
                            @else
                                <div class="float-end ms-2 badge bg-success fs-6 fw-normal">{{ __('Active') }}</div>
                            @endif

                            @if($site->favourite == 1)<div class="float-end ms-2"><i class="bi bi-star-fill text-warning"></i></div>@endif

                            <div class="fw-bold fs-5">
                                {{ $site->label }}
                            </div>

                            <div class="small text-muted">{{ __('Created at') }} {{ $site->created_at }}</div>
                        </td>


                        <td width="200">
                            <div class="d-grid gap-2">
                                <a href="{{ route('user.site.config', ['code' => $site->code]) }}" class="btn btn-primary btn-sm"><i class="bi bi-gear"></i> {{ __('Settings') }}</a>

                                <a href="{{ route('user.site.show', ['code' => $site->code]) }}" class="btn btn-primary btn-sm mt-2"><i class="bi bi-graph-up-arrow"></i> {{ __('Dashboard') }}</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        {{ $sites->links() }}

    </div>
    <!-- end card-body -->

</div>
