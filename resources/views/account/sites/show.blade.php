<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.sites.index') }}">{{ __('Websites') }}</a></li>
                    <li class="breadcrumb-item active">{{ $site->label }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box noradius noborder bg-white rounded">
            <i class="bi bi-clock-history float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-4 fw-bold">{{ __('Last hour') }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">{{ $count_accounts ?? 0 }} {{ __('page views') }} | {{ $count_accounts ?? 0 }} {{ __('visitors') }}</div>
            <a class="btn btn-light" href="{{ route('user.site.status_checker', ['code' => $site->code]) }}">{{ __('View real time visitors') }}</a>
            
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box noradius noborder bg-white rounded">
            <i class="bi bi-graph-up-arrow float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-4 fw-bold">{{ __('Visitors') }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">{{ $count_unread_contact_messages ?? 0 }} {{ __('unread') }}, {{ $count_contact_messages ?? 0 }} {{ __('total') }}</div>
            <a class="btn btn-light" href="#">{{ __('Visitors statistics') }}</a>
        </div>
    </div>


    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box noradius noborder bg-white rounded">
            <i class="bi bi-file-earmark-text float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-4 fw-bold">{{ __('Pages') }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">{{ $count_unread_contact_messages ?? 0 }} {{ __('unread') }}, {{ $count_contact_messages ?? 0 }} {{ __('total') }}</div>
            <a class="btn btn-light" href="#">{{ __('Pages statistics') }}</a>
        </div>
    </div>


    <div class="col-12 col-md-6 col-lg-3">
        <div class="card-box noradius noborder bg-white rounded">
            <i class="bi bi-check-square float-end text-secondary fs-1"></i>
            <div class="text-dark text-uppercase mb-4 fw-bold">{{ __('Website Status Checker') }}</div>
            <div class="mb-3 text-secondary fs-6 fw-bold">{{ $count_pages ?? 0 }} {{ __('total') }}</div>
            <a class="btn btn-light" href="{{ route('user.site.status_checker', ['code' => $site->code]) }}">{{ __('Website status checker') }}</a>
        </div>
    </div>
</div>
<!-- end row -->


<div class="row">

    <div class="col-md-8 col-12">

        <div class="card">

            <div class="card-body">                

                <div class="fw-bold fs-5 mb-2">{{ $site->label }}</div>

                <div class="small text-muted mb-2">{{ __('Created at') }} {{ $site->created_at }}</div>

                <div class="">
                    {{ __('Website URL') }}: <a target="_blank" href="https://{{ $site->url }}"><b>https://{{ $site->url }}</b></a>
                </div>

                <hr>


                
            </div>
            <!-- end card-body -->

        </div>

    </div>


    <div class="col-md-4 col-12">

        <div class="card">

            <div class="card-body">

                <div class="fw-bold fs-6 mb-3">{{ __('Verify website') }}</div>

                @if (!$site->verified_at)
                    <div class="fs-6 fw-bold text-warning mb-1">{{ __('Website not verified') }}</div>

                    <a class="btn btn-light" href="#"><i class="bi bi-link"></i> {{ __('Verify website') }}</a>
                @else
                    <div class="fs-6 fw-bold text-success">{{ __('Website verified') }}</div>
                @endif

            </div>

        </div>
    </div>

</div>
