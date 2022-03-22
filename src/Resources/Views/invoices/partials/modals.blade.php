
<!-- POS invoice Modal -->
{{-- <div class="modal  fade " id="modalPOSInvoiceView" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" style="overflow: scroll;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="e-modal-title">{{ __('POS Invoice')}}</h6>
                <button type="button" class="e-btn-close btn-warning" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">

                <div id="posReciptInvoiceView" >
                    <center>
                        <div>
                            <p style="font-size: 10pt !important; font-weight: 700;" class="m-0 p-0"><b >FACTURA</b></p>
                            <p style="font-size: 10pt !important; font-weight: 700;" class="mb-0 p-0"><b>CON DERECHO A CRÉDITO FISCAL</b></p>
                            @if(auth()->user()->restorant->fel_restorant->is_unipersonal)
                                <p style="font-size: 10pt !important;" class="mb-0 p-0">{{ auth()->user()->restorant->name }}</p>
                                <p style="font-size: 10pt !important;" class="mb-0 p-0">De: @{{ invoice? invoice.razonSocialEmisor:"" }}</p>
                            @else
                                <p style="font-size: 10pt !important;" class="mb-0 p-0">@{{ invoice? invoice.razonSocialEmisor:"" }}</p>
                            @endif
                            <p style="font-size: 10pt !important; font-weight: 700;" class="m-0 p-0"><b>@{{ invoice? ((invoice.codigoSucursal == 0) ? "Casa Matriz" : ('Sucursal N. ' + invoice.codigoSucursal)) :"" }}</b></p>
                            <p style="font-size: 10pt !important; font-weight: 700;" class="m-0 p-0"><b>@{{ invoice? (invoice.numeroPuntoVenta? invoice.numeroPuntoVenta:"No. Punto Venta 0") : "" }}</b></p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0">@{{ invoice? invoice.direccion:"" }}</p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0">Teléfono: @{{ invoice? invoice.telefonoEmisor:"" }}</p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0">@{{ invoice? invoice.municipio:"" }}</p>
                            <hr>
                            <p style="font-size: 10pt !important; font-weight: 700;" class="m-0 p-0"><b>NIT</b></p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0">@{{ invoice? invoice.nitEmisor:"" }}</p>
                            <p style="font-size: 10pt !important; font-weight: 700;" class="m-0 p-0"><b>FACTURA Nº</b></>
                            <p style="font-size: 10pt !important;" class="m-0 p-0">@{{ invoice? invoice.numeroFactura:"" }}</p>
                            <p style="font-size: 10pt !important; font-weight: 700;" class="m-0 p-0"><b>CÓD. AUTORIZACIÓN</b></p>
                            <p class="m-0 p-0" style="font-size: 10pt !important;">@{{ invoice? invoice.cuf:"" }}</p>
                            <hr>
                            <div class="row" style="width: 100%">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size: 10pt !important; font-weight: 700;" class="m-0 p-0 text-right"><b>NOMBRE/RAZÓN SOCIAL:</b></p>
                                        </div>
                                        <div class="col">
                                            <p style="font-size: 10pt !important;" class="m-0 p-0 text-left">@{{ invoice? invoice.nombreRazonSocial:"" }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size: 10pt !important; font-weight: 700;" class="m-0 p-0 text-right"><b>NIT/CI/CEX:</b></p>
                                        </div>
                                        <div class="col">
                                            <p style="font-size: 10pt !important;" class="m-0 p-0 text-left">@{{ invoice? invoice.numeroDocumento:"" }} @{{ invoice? invoice.complemento:"" }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size: 10pt !important; font-weight: 700;" class="m-0 p-0 text-right"><b>COD. CLIENTE:</b></p>
                                        </div>
                                        <div class="col">
                                            <p style="font-size: 10pt !important;" class="m-0 p-0 text-left">@{{ invoice? invoice.codigoCliente:"" }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size: 10pt !important; font-weight: 700;" class="m-0 p-0 text-right"><b>F. EMISIÓN:</b></p>
                                        </div>
                                        <div class="col">
                                            <p style="font-size: 10pt !important;" class="m-0 p-0 text-left">@{{ invoice? invoice.fechaEmision:"" }}</p>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                </div>
                            </div>
                            <hr>
                        </div>
                    </center>
                    <div class="w-100">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th style="width:70% !important; " class="col-8" scope="col">{{__('Item') }}</th>
                                    <th style="width:10% !important; "  class="col-1" scope="col">{{ __('Qty') }}</th>
                                    <th style="width:10% !important; padding-right: 15px; "  class="col-1" scope="col">{{ __('P. Unitario') }}</th>
                                    <th style="width:10% !important; " class="col-2" scope="col">{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr v-for="item in (invoice?invoice.detalles:[])">
                                    <td>@{{ item.descripcion }}</td>
                                    <td>@{{ item.cantidad }}</td>
                                    <td>@{{ item.precioUnitario.toFixed(2) }}</td>
                                    <td>@{{ formatDecimal(formatPrice(item.subTotal)) }}</td>
                                </tr>
                                <tr>
                                  <th class="p-1 w-70" colspan="3">{{ __('Subtotal.') }}</th>
                                  <td class="p-1 w-30">@{{ invoice?formatDecimal(formatPrice((invoice.montoTotal*1).toFixed(2))):"" }}</td>
                                </tr>
                                
                                <tr class="blockDelivery">
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Discount') }}</th>
                                    <th></th>
                                    <td class="p-1 w-30">@{{ invoice? (invoice.descuentoAdicional? formatDecimal(formatPrice((invoice.descuentoAdicional*1).toFixed(2))) : formatDecimal(formatPrice(0))):formatDecimal(formatPrice(0)) }}</td>
                                </tr>
                                <tr class="blockDelivery">
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Total') }}</th>
                                    <th></th>
                                    <th class="p-1 w-30">@{{ invoice?formatDecimal(formatPrice((invoice.montoTotal*1).toFixed(2))):"" }}</th>
                                </tr>
                                <tr v-if="invoice&&invoice.montoGiftCard&&invoice.montoGiftCard>0" class="blockDelivery">
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Monto Gift Card') }}</th>
                                    <th></th>
                                    <th class="p-1 w-30">@{{ invoice?formatDecimal(formatPrice((invoice.montoGiftCard*1).toFixed(2))):"" }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <table id="totalInModal" style="background-color: #8392ab; color: #FFF;" class="mt-2 w-100">
                            <tbody>
                                <tr>
                                    <th class="p-1 w-70">MONTO A PAGAR Bs</th>
                                    <th class="p-1 w-30 text-right">@{{ invoice?formatDecimal(formatPrice((invoice.montoTotal*1).toFixed(2))):"" }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Importe Base Crédito Fiscal.') }}</th>
                                    <td class="p-1 w-30  text-right">@{{ invoice?formatDecimal(formatPrice((invoice.montoTotalSujetoIva*1).toFixed(2))):"" }}</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td>SON: @{{ invoice? (invoice.montoLiteral? invoice.montoLiteral : ""):"" }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                    <hr>
                    <center>
                        <div>
                            <p style="font-size: 8pt !important;" class="m-0 p-0 text-center">ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY</p>
                            <p style="font-size: 8pt !important;" class="m-0 py-2 text-center">@{{ invoice? invoice.leyenda:"" }}</p>
                            <p style="font-size: 8pt !important;" class="m-0 p-0 text-center">@{{ invoice? ((invoice.tipoEmision == 'En Linea')? "\"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea\"": "\"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido fuera de línea, verifique su envío con su proveedor o en la página web www.impuestos.gob.bo\""):"" }}</p>
                            <br />
                            <div style="margin: 10px; width:150px; height:150px;" id="qrcode"></div>
                        </div>
                    </center>  
                </div>
    
    
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn">{{ __('Close') }}</button>
                    <button id="printPosInvoiceView" v-on:click="imprimirFactura" class="btn bg-primary">{{ __('Print') }}</button>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- End POS invoice Modal -->
<!--  anular invoice Modal -->
<div class="modal  fade " id="modalAnularInvoiceView" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" style="overflow: scroll;">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="e-modal-title" id="modal-title-default">{{ __('Anulación')}}</h6>
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
                            <label>{{ __('Motivo de Anulación') }}</label>
                            <div class="input-group mb-3">
                            <select class='form-control noselecttwo' v-model='motivoAnulacion' @change="onChange($event)"  id="codeRevocationReason" >
                                <option value='0' >Selecccione un motivo de anulación</option>
                                <option v-for='motivoanulacion in motivosAnulacion' :value='motivoanulacion.codigo'>@{{ motivoanulacion.descripcion }}</option>
                             </select>
                            </div>
                            {{-- EPOS-END --}}
                        </form>
                    </div>                    
                </div>

            </div>
            <div class="modal-footer" >

                <i id="indicatoranular" style="display: none" class="fas fa-spinner fa-spin"></i>
                <button data-bs-dismiss="modal" class="btn">{{ __('Close') }}</button>
                <button id="botonanular" type="button" v-on:click="anular" class="btn bg-gradient-primary">
                    <span class="btn-inner--text text-secondary">Anular Factura</span>
                    <span class="btn-inner--icon text-secondary"><i class="ni ni-curved-next"></i></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End anular invoice Modal -->

<!-- EMIZOR-INVOICE-INSERT -->
<!-- Send Message Modal -->
@include('posinvoicingfel::invoices.partials.whatsappmodal')
<!-- End Message Modal -->
<!-- EMIZOR-INVOICE-END -->
