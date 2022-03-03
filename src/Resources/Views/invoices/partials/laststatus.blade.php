<?php
$badgeTypes=['badge-primary','badge-primary','badge-success','badge-success','badge-default','badge-warning','badge-success','badge-info','badge-danger','badge-success','badge-success','badge-success','badge-danger','badge-success','badge-success'];
?>
@if($invoice->status->count()>0)
    <span class="badge {{ $badgeTypes[$invoice->status->pluck('id')->last()] }} badge-pill">{{ __($invoice->status->pluck('alias')->last()) }}</span>
@endif  