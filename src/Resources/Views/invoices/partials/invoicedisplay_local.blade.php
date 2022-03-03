<thead class="thead-light">
    <tr>
        <th scope="col">{{ __('ID') }}</th>
        @if(auth()->user()->hasRole('admin'))
            <th scope="col">{{ __('Restaurant') }}</th>
        @endif
        <th class="table-web" scope="col">{{ __('# Factura') }}</th>
        <th class="table-web" scope="col">{{ __('Fecha Emisión') }}</th>
        <th class="table-web" scope="col">{{ __('NIT/CI') }}</th>
        <th class="table-web" scope="col">{{ __('Razón Social') }}</th>        
        <th class="table-web" scope="col">{{ __('Price') }}</th>
        <th scope="col">{{ __('Last status') }}</th>
        <th scope="col">{{ __('Actions') }}</th>
    </tr>
</thead>
<tbody>
@foreach($invoices as $invoice)
<tr>
    <td>
        
        <a class="btn badge badge-success badge-pill" onclick="verFactura({{ $invoice->order_id }})">#{{ $invoice->numeroFactura }}</a>
    </td>
    @hasrole('admin|driver')
    <th scope="row">
        <div class="media align-items-center">
            <a class="avatar-custom mr-3">
                <img class="rounded" alt="..." src={{ $invoice->restorant->icon }}>
            </a>
            <div class="media-body">
                <span class="mb-0 text-sm">{{ $invoice->restorant->name }}</span>
            </div>
        </div>
    </th>
    @endif

    <td class="table-web">
        {{ $invoice->numeroFactura }}
    </td>
    <td class="table-web">
        {{ date('d/m/Y h:i:s', strtotime($invoice->fechaEmision)) }}
    </td>
    <td class="table-web">
        {{ $invoice->numeroDocumento }}
    </td>
    <td class="table-web">
        {{ $invoice->nombreRazonSocial }}
    </td>
    
    <td class="table-web">
        @money( $invoice->montoTotal, config('settings.cashier_currency'),config('settings.do_convertion'))
    </td>
    <td>
        @include('posinvoicingfel::invoices.partials.laststatus')
    </td>
    @include('posinvoicingfel::invoices.partials.actions.table',['invoice' => $invoice ])
</tr>
@endforeach
</tbody>
