<?php
$badgeTypes=['badge-primary','badge-primary','badge-success','badge-success','badge-default','badge-warning','badge-success','badge-info','badge-danger','badge-success','badge-success','badge-success','badge-danger','badge-success','badge-success'];
$tipoEstado = $invoice->tipoEmision == 'VALIDA' ? 6:8;
?>
@if($invoice->tipoEmision)
    <span class="badge {{ $badgeTypes[$tipoEstado] }} badge-pill">{{ __($invoice->estado) }}</span>
@endif  