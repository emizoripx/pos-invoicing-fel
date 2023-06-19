<!-- POS VER invoice Modal -->
@include('posinvoicingfel::invoices.includes.posstyles')
<div class="modal  fade " id="{{ $modal_id }}" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" style="overflow: scroll;">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 style="margin-bottom: 0; line-height: 1.5; font-weight: 600; font-size: 1rem; color: #252f40; margin-top: 0;" id="modal-title-default">{{ __('POS Invoice')}}</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-posinvoicingfel::templateinvoice :pos_invoice="$pos_invoice" />
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn">{{ __('Close') }}</button>
                    <button @isset($is_order) onclick="imprimirFactura()" @else id="printPosInvoiceView" v-on:click="imprimirFactura" @endisset class="btn bg-primary">{{ __('Print') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End POS invoice Modal -->
