<?php
$badgeTypes=['badge-primary','badge-primary','badge-success','badge-success','badge-default','badge-warning','badge-success','badge-info','badge-danger','badge-success','badge-success','badge-success','badge-danger','badge-success','badge-success'];
$tipoEstado = $invoice->estado == 'VALIDA' ? 6:8;
?>
@if($invoice->estado)
    <a href="{{ $invoice->url_sin }}" target="__blank" ><span class="badge {{ $badgeTypes[$tipoEstado] }} badge-pill">{{ __($invoice->estado) }}</span></a>
@endif  