<?php $template_name = isset(auth()->user()->restorant->fel_restorant->settings['template_invoice']) ? auth()->user()->restorant->fel_restorant->settings['template_invoice'] : 'default'; ?>
@switch( $template_name )
    @case('locotos')
        <x-Templates.locotos :pos_invoice="$posInvoice" />
        @break
    @default
        <x-Templates.default :pos_invoice="$posInvoice" />
@endswitch

