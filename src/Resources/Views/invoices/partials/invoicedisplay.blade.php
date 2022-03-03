<thead class="thead-light">
    <tr>
        <th scope="col">{{ __('ID') }}</th>
        @hasrole('admin|driver')
            <th scope="col">{{ __('Restaurant') }}</th>
        @endif
        <th class="table-web" scope="col">{{ __('Created') }}</th>
        <th class="table-web" scope="col">{{ __('Time Slot') }}</th>
        <th class="table-web" scope="col">{{ __('Method') }}</th>
        <th scope="col">{{ __('Last status') }}</th>
        @hasrole('admin|owner|driver')
            <th class="table-web" scope="col">{{ __('Client') }}</th>
        @endif
        @if(auth()->user()->hasRole('admin'))
            <th class="table-web" scope="col">{{ __('Address') }}</th>
        @endif
        @if(auth()->user()->hasRole('owner'))
            <th class="table-web" scope="col">{{ __('Items') }}</th>
        @endif
        @hasrole('admin|owner')
            <th class="table-web" scope="col">{{ __('Driver') }}</th>
        @endif
        <th class="table-web" scope="col">{{ __('Price') }}</th>
        <th class="table-web" scope="col">{{ __('Delivery') }}</th>
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner') || auth()->user()->hasRole('driver'))
            <th scope="col">{{ __('Actions') }}</th>
        @endif
    </tr>
</thead>
<tbody>
@foreach($invoices as $invoice)
<tr>
    <td>
        
        <a class="btn badge badge-success badge-pill" href="{{ route('invoices.show',$invoice->id )}}">#{{ $invoice->id }}</a>
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
        {{ $invoice->created_at->locale(Config::get('app.locale'))->isoFormat('LLLL') }}
    </td>
    <td class="table-web">
        {{ $invoice->time_formated }}
    </td>
    <td class="table-web">
        <span class="badge badge-primary badge-pill">{{ $invoice->getExpeditionType() }}</span>
    </td>
    <td>
        @include('posinvoicingfel::invoices.partials.laststatus')
    </td>
    @hasrole('admin|owner|driver')
    <td class="table-web">
       {{ $invoice->client?$invoice->client->name:"" }}
    </td>
    @endif
    @if(auth()->user()->hasRole('admin'))
        <td class="table-web">
            {{ $invoice->address?$invoice->address->address:"" }}
        </td>
    @endif
    @if(auth()->user()->hasRole('owner'))
        <td class="table-web">
            {{ count($invoice->items) }}
        </td>
    @endif
    @hasrole('admin|owner')
        <td class="table-web">
            {{ !empty($invoice->driver->name) ? $invoice->driver->name : "" }}
        </td>
    @endif
    <td class="table-web">
        @money( $invoice->invoice_price_with_discount, config('settings.cashier_currency'),config('settings.do_convertion'))

    </td>
    <td class="table-web">
        @money( $invoice->delivery_price, config('settings.cashier_currency'),config('settings.do_convertion'))
    </td>
    @include('posinvoicingfel::invoices.partials.actions.table',['invoice' => $invoice ])
</tr>
@endforeach
</tbody>
