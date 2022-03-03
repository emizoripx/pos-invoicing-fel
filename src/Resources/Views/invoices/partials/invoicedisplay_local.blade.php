<thead class="thead-light">
    <tr>
        <th scope="col">{{ __('ID') }}</th>
        @if(auth()->user()->hasRole('admin'))
            <th scope="col">{{ __('Restaurant') }}</th>
        @endif
        <th class="table-web" scope="col">{{ __('Created') }}</th>
        <th class="table-web" scope="col">{{ !config('settings.is_whatsapp_ordering_mode') ? __('Table / Method') : __('Method') }}</th>
        <th class="table-web" scope="col">{{ __('Items') }}</th>
        <th class="table-web" scope="col">{{ __('Price') }}</th>
        <th scope="col">{{ __('Last status') }}</th>
        <th scope="col">{{ __('Actions') }}</th>
    </tr>
</thead>
<tbody>
@foreach($invoices as $invoice)
<tr>
    <td>
        
        <a class="btn badge badge-success badge-pill" onclick="verFactura({{ $invoice->id }})">#{{ $invoice->id }}</a>
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
        {{ $invoice->created_at->locale(Config::get('app.locale'))->isoFormat('LLLL')  }}
    </td>
    <td class="table-web">
        {{ $invoice->getExpeditionType() }}
    </td>
    <td class="table-web">
        {{ count($invoice->items) }}
    </td>
    <td class="table-web">
        @money( $invoice->order_price_with_discount, config('settings.cashier_currency'),config('settings.do_convertion'))
    </td>
    <td>
        @include('posinvoicingfel::invoices.partials.laststatus')
    </td>
    @include('posinvoicingfel::invoices.partials.actions.table',['invoice' => $invoice ])
</tr>
@endforeach
</tbody>
