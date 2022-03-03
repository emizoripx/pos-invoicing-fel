@if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner') || auth()->user()->hasRole('driver'))
<?php
$lastStatusAlisas= "just_created";
// =$invoice->status->pluck('alias')->last();
?>
<div class="card-footer py-4">
    <h6 class="heading-small text-muted mb-4">{{ __('Actions') }}</h6   >
    <nav class="justify-content-end" aria-label="...">
    @if(auth()->user()->hasRole('admin'))
        <script>
            function setSelectedInvoiceId(id){
                $("#form-assing-driver").attr("action", "/updatestatus/assigned_to_driver/"+id);
            }
        </script>
        @if($lastStatusAlisas == "just_created")
            <a href="{{ url('updatestatus/accepted_by_admin/'.$invoice->id) }}" class="btn btn-primary">{{ __('Accept') }}</a>
            <a href="{{ url('updatestatus/rejected_by_admin/'.$invoice->id) }}" class="btn btn-danger">{{ __('Reject') }}</a>
        
        @elseif($lastStatusAlisas == "accepted_by_restaurant"&&$invoice->delivery_method.""!="2")
            <button type="button" class="btn btn-primary" onClick=(setSelectedInvoiceId({{ $invoice->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</button>
        @elseif($lastStatusAlisas == "rejected_by_driver"&&$invoice->delivery_method.""!="2")
            <button type="button" class="btn btn-primary" onClick=(setSelectedInvoiceId({{ $invoice->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</button>
        @elseif($lastStatusAlisas == "prepared"&&$invoice->delivery_method.""!="2"&&$invoice->driver==null)
            <button type="button" class="btn btn-primary" onClick=(setSelectedInvoiceId({{ $invoice->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</button>
        @else
            <p>{{ __('No actions for you right now!') }}</p>
       @endif
    @endif
    @if(auth()->user()->hasRole('owner')||auth()->user()->hasRole('driver'))
        @include('invoices.partials.actions.actions')
    @endif
    </nav>
</div>
@endif
