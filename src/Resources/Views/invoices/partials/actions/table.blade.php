<?php
$lastStatusAlisas=$invoice->status->pluck('alias')->last();
?>
@if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner') || auth()->user()->hasRole('driver') || auth()->user()->hasRole('staff'))
    @if(auth()->user()->hasRole('admin'))
    <script>
        function setSelectedInvoiceId(id){
            $("#form-assing-driver").attr("action", "updatestatus/assigned_to_driver/"+id);
        }
    </script>
    <td>
        @if($lastStatusAlisas == "just_created")
            <a href="{{'updatestatus/accepted_by_admin/'.$invoice->id }}" class="btn btn-success btn-sm order-action">{{ __('Accept') }}</a>
            <a href="{{'updatestatus/rejected_by_admin/'.$invoice->id }}" class="btn btn-danger btn-sm order-action">{{ __('Reject') }}</a>
        @elseif(($lastStatusAlisas == "accepted_by_restaurant"||$lastStatusAlisas == "rejected_by_driver")&&$invoice->delivery_method.""!="2")
            <button type="button" class="btn btn-primary btn-sm order-action" onClick=(setSelecteInvoiceId({{ $invoice->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</a>
        @elseif($lastStatusAlisas == "prepared"&&$invoice->driver==null)
            <button type="button" class="btn btn-primary btn-sm order-action" onClick=(setSelectedInvoiceId({{ $invoice->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</a>
        @else
            <small>{{ __('No actions for you right now!') }}</small>
        @endif
    </td>
    @endif
    @if(auth()->user()->hasRole('owner') || auth()->user()->hasRole('driver')  || auth()->user()->hasRole('staff') )
    <td>
        @include('posinvoicingfel::invoices.partials.actions.actions')
    </td>
    @endif
@endif
