<?php
$badgeTypes=['badge-primary','badge-primary','badge-success','badge-success','badge-default','badge-warning','badge-success','badge-info','badge-danger','badge-success','badge-success','badge-success','badge-danger','badge-success','badge-success'];
$tipoEstado = $file->state == 'processed' ? 6:7;
?>
@if($file->state == 'observed')
    <span class="badge {{ $badgeTypes[5] }} badge-pill">{{ __($file->state) }}</span>
@elseif($file->state != 'pending')
    <span class="badge {{ $badgeTypes[$tipoEstado] }} badge-pill">{{ __($file->state) }}</span>
@else
    <span class="badge {{ $badgeTypes[4] }} badge-pill">{{ __($file->state) }}</span>

@endif  