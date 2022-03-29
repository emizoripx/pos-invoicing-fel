<thead class="thead-light">
    <tr>
        <th style="max-width: 10%" scope="col">{{ __('# ID Archivo') }}</th>
        {{-- @if(auth()->user()->hasRole('admin'))
            <th scope="col">{{ __('Restaurant') }}</th>
        @endif --}}
        <th style="max-width: 10%" class="table-web" scope="col">{{ __('Fecha Creación') }}</th>
        <th style="max-width: 20%" class="table-web" scope="col">{{ __('Nombre de Archivo') }}</th>
        <th style="max-width: 10%" scope="col">{{ __('Estado') }}</th>
        <th style="max-width: 10%" class="table-web" scope="col">{{ __('Fecha Procesado') }}</th>
        <th style="max-width: 20%" class="table-web" scope="col">{{ __('Errores') }}</th>        
        <th style="max-width: 15%" scope="col">{{ __('Actions') }}</th>
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
        {{ is_null($file->processed_at) ? '' : date('d/m/Y h:i:s', strtotime($file->processed_at)) }}
    </td>
    <td>
        <div>{{ isset($file->errors['error']) ? $file->errors['error'] : '' }}</div>
    </td>
    @include('posinvoicingfel::contingency.partials.actions.table',['file' => $file ])
</tr>
@endforeach
</tbody>
