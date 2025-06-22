<div>
    <div class="float-end ms-2">
        <a class="btn btn-light btn-sm btn-gear text-white" href="{{ route('user.site.show', ['code' => $site->code]) }}"><i class="bi bi-arrow-repeat"></i> {{ __('Reload') }}</a>
    </div>

    <div class="page-title">
        <nav aria-label="breadcrumb" class="breadcrumb-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.sites.index') }}">{{ __('Websites') }}</a></li>
                <li class="breadcrumb-item active">{{ $site->label }}</li>
            </ol>
        </nav>
    </div>


    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body">


                <div>

                    

                </div>

            </div>
        </div>


    </div>
</div>
