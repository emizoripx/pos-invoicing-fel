<thead class="thead-light">
    <tr>
        <th scope="col">{{ __('# ID Archivo') }}</th>
        {{-- @if(auth()->user()->hasRole('admin'))
            <th scope="col">{{ __('Restaurant') }}</th>
        @endif --}}
        <th class="table-web" scope="col">{{ __('Fecha Creación') }}</th>
        <th class="table-web" scope="col">{{ __('Nombre de Archivo') }}</th>
        <th scope="col">{{ __('Estado') }}</th>
        <th class="table-web" scope="col">{{ __('Fecha Procesado') }}</th>
        <th class="table-web" scope="col">{{ __('Errores') }}</th>        
        <th scope="col">{{ __('Actions') }}</th>
    </tr>
</thead>
<tbody>
@foreach($contingency_files as $file)
<tr>
    <td>
        
        <a class="btn badge badge-success badge-pill" >#{{ $file->id }}</a>
    </td>
    {{-- @hasrole('admin|driver')
    <th scope="row">
        <div class="media align-items-center">
            <a class="avatar-custom mr-3">
                <img class="rounded" alt="..." src={{ $file->restorant->icon }}>
            </a>
            <div class="media-body">
                <span class="mb-0 text-sm">{{ $file->restorant->name }}</span>
            </div>
        </div>
    </th>
    @endif --}}

    <td class="table-web">
        {{ date('d/m/Y h:i:s', strtotime($file->created_at)) }}
    </td>
    <td class="table-web">
        {{ $file->file_name }}
    </td>
    
    <td>
        @include('posinvoicingfel::contingency.partials.laststatus')
    </td>
    <td class="table-web">
        {{ $file->errors }}
    </td>
    {{-- @include('posinvoicingfel::invoices.partials.actions.table',['invoice' => $invoice ]) --}}
</tr>
@endforeach
</tbody>
