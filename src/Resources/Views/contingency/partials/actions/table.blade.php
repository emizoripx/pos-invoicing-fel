<?php
// invoice->status->pluck('alias')->last();
?>
@if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner'))
    <td>
        @include('posinvoicingfel::contingency.partials.actions.actions')
    </td>
@endif
