<!-- POS VER invoice Modal -->
<div class="modal  fade " id="modalCreateInvoiceView" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" style="overflow: scroll;">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">{{ __('POS Invoice')}}</h6>
                <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <div id="posReciptInvoiceCrear" class="ml-1">
    
                    <div class="modal-footer">
                        <button data-bs-dismiss="modal" class="btn bg-gradient-default">{{ __('Close') }}</button>                        
                        <!-- <button v-on click="imprimirFactura" class="btn bg-gradient-primary"> 'Print' </button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End POS invoice Modal -->