<!--  anular invoice Modal -->
<div class="modal  fade " id="modalErrorsInvoice" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" style="overflow: scroll;">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="e-modal-title" id="modal-title-default">{{ __('Errores de la Factura')}}</h6>
                <button type="button" class="e-btn-close btn-warning" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                {{-- EPOS-INSERT --}}
                {{-- EPOS-END --}}
                <div v-if="invoice&&invoice.errores">
                        <table style="width: 100%; padding:30px;">
                            <thead style="border-bottom: 1px solid rgb(202, 199, 199); margin-bottom: 5px;">
                                <th style="width: 20%;">Código</th>
                                <th style="width: 100%;">Descripción</th>
                            </thead>
                            <tbody>
                                <tr v-for="error in (invoice?invoice.errores:[])">
                                    <td> @{{ error.code ? error.code : ''  }} </td>
                                    <td> @{{ error.description ? error.description : '' }} </td>
                                </tr>
                            </tbody>
                        </table> 
                </div>

            </div>
            <div class="modal-footer" >

                {{-- <button data-bs-dismiss="modal" class="btn" onclick="hidePOSInvoiceModal(true)" >{{ __('Close') }}</button> --}}
                <button id="botonclosemodal" data-bs-dismiss="modal" class="btn" onclick="showOrHideErrosModal(false)" >{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- End anular invoice Modal -->