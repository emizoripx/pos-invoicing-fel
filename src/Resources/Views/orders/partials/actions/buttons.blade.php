@if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner') || auth()->user()->hasRole('driver'))
<?php
$lastStatusAlisas=$order->status->pluck('alias')->last();
?>
<div class="card-footer py-4">
    <h6 class="heading-small text-muted mb-4">{{ __('Actions') }}</h6   >
    <nav class="justify-content-end" aria-label="...">
    @if(auth()->user()->hasRole('admin'))
        <script>
            function setSelectedOrderId(id){
                $("#form-assing-driver").attr("action", "/updatestatus/assigned_to_driver/"+id);
            }
        </script>
        @if($lastStatusAlisas == "just_created")
            <a href="{{ url('updatestatus/accepted_by_admin/'.$order->id) }}" class="btn btn-primary">{{ __('Accept') }}</a>
            <a href="{{ url('updatestatus/rejected_by_admin/'.$order->id) }}" class="btn btn-danger">{{ __('Reject') }}</a>
        
        @elseif($lastStatusAlisas == "accepted_by_restaurant"&&$order->delivery_method.""!="2")
            <button type="button" class="btn btn-primary" onClick=(setSelectedOrderId({{ $order->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</button>
        @elseif($lastStatusAlisas == "rejected_by_driver"&&$order->delivery_method.""!="2")
            <button type="button" class="btn btn-primary" onClick=(setSelectedOrderId({{ $order->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</button>
        @elseif($lastStatusAlisas == "prepared"&&$order->delivery_method.""!="2"&&$order->driver==null)
            <button type="button" class="btn btn-primary" onClick=(setSelectedOrderId({{ $order->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</button>
        @else
            <p>{{ __('No actions for you right now!') }}</p>
       @endif
    @endif
    @if(auth()->user()->hasRole('owner')||auth()->user()->hasRole('driver'))
        @include('orders.partials.actions.actions')
    @endif
    </nav>
</div>
<div class="card-footer py-4" id="viewButonInvoice">
    <nav class="justify-content-end" aria-label="...">
        <div>
            <i id="indicatorInvoiceOrder" class="fas fa-spinner fa-spin"></i>            
            <button id="botonInvoiceOrder" v-if="titleButon != 'None'" style="display: none" v-on:click="abrirModal" class="btn btn-sm" />@{{ titleButon }}</button>
            <button id="botonInvoiceOrderIntentar" style="display: none" v-on:click="getInvoice()" class="btn btn-sm" />Volver a Intentar</button>
        </div>
    </nav>
    @include('orders.partials.modalcreateinvoice')
    @include('orders.partials.modalviewinvoice')
</div>
@endif
