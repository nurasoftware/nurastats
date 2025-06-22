<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Invoices') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">


    <div class="card-body">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                @if ($message == 'paid')
                    {{ __('Invoice paid') }}
                @endif
            </div>
        @endif


        @if (count($invoices) == 0)
            {{ __("You don't have any paid invoice") }}
        @else
            <div class="table-responsive-md">
                <table class="table table-bordered">
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>
                                <div class="badge float-end ms-2 @if ($invoice->status == 'completed') bg-success @else bg-warning @endif ">
                                    @if ($invoice->status == 'completed')
                                        {{ __('Paid') }}
                                    @else
                                        {{ $invoice->status }}
                                    @endif
                                </div>

                                <div class="fw-bold mb-1 fs-6">
                                    {{ __('Invoice') }} #{{ $invoice->id }}
                                </div>
                                <div class="small text-muted">
                                    {{ $invoice->date()->toFormattedDateString() }}
                                   
                                </div>
                            </td>
                            <td width="160">
                                <b>Total: {{ $invoice->total() }}</b>
                                <div class="small text-muted mt-2">
                                    Tax: {{ $invoice->tax() }}
                                </div>
                            </td>
                            <td width="120">
                                <a target="_blank" href="{{ route('central.user.invoice.download', ['invoice' => $invoice->id]) }}" class="btn btn-light ms-2"><i class="bi bi-download"></i> {{ __('PDF') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="small text-muted"><i class="bi bi-info-circle"></i> {{ __('Dates are in UTC (Coordinated Universal Time) format') }}</div>
        @endif

    </div>
    <!-- end card-body -->

</div>
