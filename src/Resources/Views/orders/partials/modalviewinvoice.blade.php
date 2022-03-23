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
                <div id="{{ $pos_invoice }}" style="background-color: white !important;" >
                    <center>
                        <?php $font_size = isset(auth()->user()->restorant->fel_restorant->settings['font_size']) ? auth()->user()->restorant->fel_restorant->settings['font_size'] : 10 ?>

                        <div style="color: black !important; background-color: white !important;">
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0"><b >FACTURA</b></p>
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="mb-0 p-0"><b>CON DERECHO A CRÉDITO FISCAL</b></p>
                            @if(auth()->user()->restorant->fel_restorant->is_unipersonal)
                                <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="mb-0 p-0">{{ auth()->user()->restorant->name }}</p>
                                <p style="font-size: {{ $font_size }}pt !important; font-weight: 500; color: black;" class="mb-0 p-0">De: @{{ invoice? invoice.razonSocialEmisor:"" }}</p>
                            @else
                                <p style="font-size: {{ $font_size }}pt !important; font-weight: 500; color: black;" class="mb-0 p-0">@{{ invoice? invoice.razonSocialEmisor:"" }}</p>
                            @endif
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0"><b>@{{ invoice? ((invoice.codigoSucursal == 0) ? "Casa Matriz" : ('Sucursal N. ' + invoice.codigoSucursal)) :"" }}</b></p>
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0"><b>@{{ invoice? (invoice.numeroPuntoVenta? invoice.numeroPuntoVenta:"No. Punto Venta 0") : "" }}</b></p>
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0">@{{ invoice? invoice.direccion:"" }}</p>
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0">Teléfono: @{{ invoice? invoice.telefonoEmisor:"" }}</p>
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0">@{{ invoice? invoice.municipio:"" }}</p>
                            <hr style="margin-top: 10px; margin-bottom: 10px;">
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0"><b>NIT</b></p>
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0">@{{ invoice? invoice.nitEmisor:"" }}</p>
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0"><b>FACTURA Nº</b></>
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0">@{{ invoice? invoice.numeroFactura:"" }}</p>
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0"><b>CÓD. AUTORIZACIÓN</b></p>
                            <p class="m-0 p-0" style="font-size: {{ $font_size }}pt !important; font-weight: 500; overflow-wrap: break-word;">@{{ invoice? invoice.cuf:"" }}</p>
                            <hr style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="row" style="color: black;">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0 text-right"><b>NOMBRE/RAZÓN SOCIAL:</b></p>
                                        </div>
                                        <div class="col">
                                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0 text-left">@{{ invoice? invoice.nombreRazonSocial:"" }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0 text-right"><b>NIT/CI/CEX:</b></p>
                                        </div>
                                        <div class="col">
                                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0 text-left">@{{ invoice? invoice.numeroDocumento:"" }} @{{ invoice? invoice.complemento:"" }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0 text-right"><b>COD. CLIENTE:</b></p>
                                        </div>
                                        <div class="col">
                                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0 text-left">@{{ invoice? invoice.codigoCliente:"" }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0 text-right"><b>F. EMISIÓN:</b></p>
                                        </div>
                                        <div class="col">
                                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0 text-left">@{{ invoice? invoice.fechaEmision:"" }}</p>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                </div>
                            </div>
                            <hr style="margin-top: 10px; margin-bottom: 10px;">
                        </div>
                    </center>
                    <div class="w-100" style="background-color: white !important;">
                        <table class="w-100" style="font-size: {{ $font_size }}pt !important; color: black; background-color: white !important;">
                            <thead>
                                <tr>
                                    <th style="width:70% !important; " scope="col">{{__('Item') }}</th>
                                    <th style="width:10% !important; padding-left: 9px; " scope="col">{{ __('Qty') }}</th>
                                    <th style="width:10% !important; padding-right: 15px; " scope="col">{{ __('P. Unitario') }}</th>
                                    <th style="width:10% !important; " scope="col">{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr v-for="item in (invoice?invoice.detalles:[])">
                                    <td>@{{ item.descripcion }}</td>
                                    <td style="padding-left: 9px;">@{{ item.cantidad }}</td>
                                    <td>@{{ item.precioUnitario.toFixed(2) }}</td>
                                    <td style="padding-right: 5px;" class="text-right">@{{ formatDecimal(formatPrice(item.subTotal)) }}</td>
                                </tr>
                                <tr>
                                  <th class="p-1 w-70" colspan="3">{{ __('Subtotal.') }}</th>
                                  <td class="p-1 w-30 text-right">@{{ invoice?formatDecimal(formatPrice((invoice.montoTotal*1).toFixed(2))):"" }}</td>
                                </tr>
                                
                                <tr class="blockDelivery">
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Discount') }}</th>
                                    <th></th>
                                    <td class="p-1 w-30 text-right">@{{ invoice? (invoice.descuentoAdicional? formatDecimal(formatPrice((invoice.descuentoAdicional*1).toFixed(2))) : formatDecimal(formatPrice(0))):formatDecimal(formatPrice(0)) }}</td>
                                </tr>
                                <tr class="blockDelivery">
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Total') }}</th>
                                    <th></th>
                                    <th class="p-1 w-30 text-right">@{{ invoice?formatDecimal(formatPrice((invoice.montoTotal*1).toFixed(2))):"" }}</th>
                                </tr>
                                <tr v-if="invoice&&invoice.montoGiftCard&&invoice.montoGiftCard>0" class="blockDelivery">
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Monto Gift Card') }}</th>
                                    <th></th>
                                    <th class="p-1 w-30 text-right">@{{ invoice?formatDecimal(formatPrice((invoice.montoGiftCard*1).toFixed(2))):"" }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <table id="totalInModal" style="font-size: {{ $font_size }}pt !important; background-color: #1f2227; color: #FFF;" class="mt-2 w-100">
                            <tbody>
                                <tr>
                                    <th class="p-1 w-70">MONTO A PAGAR Bs</th>
                                    <th class="p-1 w-30 text-right">@{{ invoice?formatDecimal(formatPrice((invoice.montoTotal*1).toFixed(2))):"" }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <table class="w-100" style="font-size: {{ $font_size }}pt !important; color:black;">
                            <tbody>
                                <tr>
                                    <th></th>
                                    <th class="p-1 w-70">{{ __('Importe Base Crédito Fiscal.') }}</th>
                                    <td class="p-1 w-30  text-right">@{{ invoice?formatDecimal(formatPrice((invoice.montoTotalSujetoIva*1).toFixed(2))):"" }}</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td colspan="2">SON: @{{ invoice? (invoice.montoLiteral? invoice.montoLiteral : ""):"" }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <hr style="margin-top: 10px; margin-bottom: 10px;">
                    </div>
                    <center style="background-color: white !important;">
                        <div style="color: black !important; background-color: white !important;">
                            <p style="font-size: 8pt !important; font-weight: 500;" class="m-0 p-0 text-center">ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY</p>
                            <p style="font-size: 8pt !important; font-weight: 500;" class="m-0 py-2 text-center">@{{ invoice? invoice.leyenda:"" }}</p>
                            <p style="font-size: 8pt !important; font-weight: 500;" class="m-0 p-0 text-center">@{{ invoice? ((invoice.tipoEmision == 'En Linea')? "\"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea\"": "\"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido fuera de línea, verifique su envío con su proveedor o en la página web www.impuestos.gob.bo\""):"" }}</p>
                            <br />
                            {{-- <img :src=" 'https://api.qrserver.com/v1/create-qr-code/?ecc=M&size=150x150&data='+(invoice? encodeURIComponent(invoice.url_sin):'')" class="image mr-3" alt=""/> --}}
                            <div style="margin: 10px; width:150px; height:150px;" id="qrcode"></div>
                        </div>
                    </center>  
                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn">{{ __('Close') }}</button>
                    <button @isset($is_order) onclick="imprimirFactura()" @else id="printPosInvoiceView" v-on:click="imprimirFactura" @endisset class="btn bg-primary">{{ __('Print') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End POS invoice Modal -->