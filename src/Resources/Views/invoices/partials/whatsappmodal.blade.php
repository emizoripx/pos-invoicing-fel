<!--  anular invoice Modal -->
<div class="modal  fade " id="modalWhatsappSend" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" style="overflow: scroll;">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="e-modal-title" id="modal-title-default">{{ __('Enviar Factura por Whatsapp')}}</h6>
                <button type="button" class="e-btn-close btn-warning" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                {{-- EPOS-INSERT --}}
                {{-- EPOS-END --}}
                <div class="row">
                    <div class="col">
                        <form role="form text-left">
                            {{-- EPOS-INSERT --}}
                            <label>{{ __('Número de Teléfono') }}</label>
                            <div class="input-group mb-3">
                                <input class="form-control" type="number" name="client_phone_number" id="client_phone_number"  placeholder="Número Telófono" v-model='client_phone_number' required>
                            </div>
                            {{-- EPOS-END --}}
                        </form>
                    </div>                    
                </div>

            </div>
            <div class="modal-footer" >

                <i id="indicatorenviar" style="display: none" class="fas fa-spinner fa-spin"></i>
                {{-- <button data-bs-dismiss="modal" class="btn" onclick="hidePOSInvoiceModal(true)" >{{ __('Close') }}</button> --}}
                <button id="botonclosemodal" data-bs-dismiss="modal" class="btn" onclick="hidePOSInvoiceModal(true)" >{{ __('Close') }}</button>
                <button id="botonenviar" type="button" v-on:click="sendMessage(invoice_id)" class="btn bg-gradient-primary">
                    <span class="btn-inner--text text-secondary">Enviar</span>
                    <span class="btn-inner--icon text-secondary"><i class="ni ni-curved-next"></i></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End anular invoice Modal -->