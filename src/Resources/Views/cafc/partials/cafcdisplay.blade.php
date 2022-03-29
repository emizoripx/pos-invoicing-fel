<thead class="thead-light">
    <tr>
        <th scope="col">{{ __('# ID') }}</th>
        <th class="table-web" scope="col">{{ __('CAFC') }}</th>
        <th class="table-web" scope="col">{{ __('Descripción') }}</th>
        <th class="table-web" scope="col">{{ __('Desde #Factura') }}</th>
        <th class="table-web" scope="col">{{ __('Hasta #Factura') }}</th>
        <th class="table-web" scope="col">{{ __('Último Número Aplicado') }}</th>        
        <th scope="col">{{ __('Actions') }}</th>
    </tr>
</thead>
<tbody>
@foreach($cafcs as $cafc)
<tr>
    <td>
        
        <a class="btn badge badge-success badge-pill" >#{{ $cafc->id }}</a>
    </td>

    <td class="table-web">
        {{ $cafc->cafc }}
    </td>
    <td class="table-web">
        {{ $cafc->description }}
    </td>
    
    <td>
        {{ $cafc->from_invoice_number }}
    </td>
    <td class="table-web">
        {{ $cafc->to_invoice_number }}
    </td>
    <td class="table-web">
        {{ $cafc->last_number_applied }}
    </td>
    <td>
        @include('posinvoicingfel::cafc.partials.actions.table',['cafc' => $cafc ])
    </td>
</tr>
@endforeach
</tbody>
