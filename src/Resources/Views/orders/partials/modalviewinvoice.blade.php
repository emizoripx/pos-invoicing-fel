<!-- POS VER invoice Modal -->
<div class="modal  fade " id="modalPOSInvoiceView" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" style="overflow: scroll;">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">{{ __('POS Invoice')}}</h6>
                <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="posReciptInvoiceView" class="ml-1">
                    <center> asdasd
                        <div>
                            <p style="font-size: 10pt !important;" class="m-0 p-0"><b >FACTURA</b></p>
                            <p style="font-size: 10pt !important;" class="mb-0 p-0"><b>CON DERECHO A CRÉDITO FISCAL</b></p>
                            <p style="font-size: 10pt !important;" class="mb-0 p-0">@{{ invoice? invoice.razonSocialEmisor:"" }}</p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0"><b>@{{ invoice? ((invoice.codigoSucursal == 0) ? "Casa Matriz" : ('Sucursal N. ' + invoice.codigoSucursal)) :"" }}</b></p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0"><b>@{{ invoice? (invoice.numeroPuntoVenta? invoice.numeroPuntoVenta:"No. Punto Venta 0") : "" }}</b></p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0">@{{ invoice? invoice.direccion:"" }}</p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0">Teléfono: @{{ invoice? invoice.telefonoEmisor:"" }}</p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0">@{{ invoice? invoice.municipio:"" }}</p>
                            <hr>
                            <p style="font-size: 10pt !important;" class="m-0 p-0"><b>NIT</b></p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0">@{{ invoice? invoice.nitEmisor:"" }}</p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0"><b>FACTURA Nº</b></>
                            <p style="font-size: 10pt !important;" class="m-0 p-0">@{{ invoice? invoice.numeroFactura:"" }}</p>
                            <p style="font-size: 10pt !important;" class="m-0 p-0"><b>CÓD. AUTORIZACIÓN</b></p>
                            <p class="m-0 p-0" style="font-size: 10pt !important;">@{{ invoice? invoice.cuf:"" }}</p>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <p style="font-size: 10pt !important;" class="m-0 p-0 text-right"><b>NOMBRE/RAZÓN SOCIAL:</b></p>
                                    <p style="font-size: 10pt !important;" class="m-0 p-0 text-right"><b>NIT/CI/CEX:</b></p>
                                    <p style="font-size: 10pt !important;" class="m-0 p-0 text-right"><b>COD. CLIENTE:</b></p>
                                    <p style="font-size: 10pt !important;" class="m-0 p-0 text-right"><b>F. EMISIÓN:</b></p>
                                </div>
                                <div class="col">
                                    <p style="font-size: 10pt !important;" class="m-0 p-0 text-left">@{{ invoice? invoice.nombreRazonSocial:"" }}</p>
                                    <p style="font-size: 10pt !important;" class="m-0 p-0 text-left">@{{ invoice? (invoice.numeroDocumento + (invoice.complemento? invoice.complemento: "")):"" }}</p>
                                    <p style="font-size: 10pt !important;" class="m-0 p-0 text-left">@{{ invoice? invoice.codigoCliente:"" }}</p>
                                    <p style="font-size: 10pt !important;" class="m-0 p-0 text-left">@{{ invoice? invoice.fechaEmision:"" }}</p>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </center>
                    <div class="table-responsive w-100">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th style="width:50%;" class="col-8" scope="col">{{__('Item') }}</th>
                                    <th style="width:25%;"  class="col-2" scope="col">{{ __('Qty') }}</th>
                                    <th  style="width:25%;" class="col-2" scope="col">{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr v-for="item in (invoice?invoice.detalles:[])">
                                    <td>@{{ item.descripcion }}</td>
                                    <td>@{{ item.cantidad }}</td>
                                    <td>@{{ formatPrice(item.subTotal) }}</td>
                                </tr>
                                <tr>
                                  <th class="p-1 w-70" colspan="2">{{ __('Subtotal.') }}</th>
                                  <td class="p-1 w-30">@{{ invoice?formatPrice((invoice.montoTotal*1).toFixed(2)):"" }}</td>
                                </tr>
                                
                                <tr class="blockDelivery">
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Discount') }}</th>
                                    <td class="p-1 w-30">@{{ invoice? (invoice.descuentoAdicional? formatPrice((invoice.descuentoAdicional*1).toFixed(2)) : formatPrice(0)):formatPrice(0) }}</td>
                                </tr>
                                <tr class="blockDelivery">
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Total') }}</th>
                                    <th class="p-1 w-30">@{{ invoice?formatPrice((invoice.montoTotal*1).toFixed(2)):"" }}</th>
                                </tr>
                                <tr v-if="invoice&&invoice.montoGiftCard&&invoice.montoGiftCard>0" class="blockDelivery">
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Monto Gift Card') }}</th>
                                    <th class="p-1 w-30">@{{ invoice?formatPrice((invoice.montoGiftCard*1).toFixed(2)):"" }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <table id="totalInModal" class="mt-2 w-100">
                            <tbody>
                                <tr>
                                    <th class="p-1 w-70">MONTO A PAGAR Bs</th>
                                    <th class="p-1 w-30 text-right">@{{ invoice?formatPrice((invoice.montoTotal*1).toFixed(2)):"" }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Importe Base Crédito Fiscal.') }}</th>
                                    <td class="p-1 w-30  text-right">@{{ invoice?formatPrice((invoice.montoTotalSujetoIva*1).toFixed(2)):"" }}</td>
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
                            <img :src=" 'https://api.qrserver.com/v1/create-qr-code/?ecc=M&size=150x150&data='+(invoice? encodeURIComponent(invoice.url_sin):'')" class="image mr-3" alt=""/>
                        </div>
                    </center>  
                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn">{{ __('Close') }}</button>
                    <button onclick="imprimirFactura()" class="btn bg-primary">{{ __('Print') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End POS invoice Modal -->