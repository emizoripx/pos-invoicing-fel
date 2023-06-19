<div id="{{ $posInvoice ?? '' }}" style="background-color: white !important;" >
    <center>
        <?php $font_size = isset(auth()->user()->restorant->fel_restorant->settings['font_size']) ? auth()->user()->restorant->fel_restorant->settings['font_size'] : 10 ?>
        <?php $whitout_total_background = isset(auth()->user()->restorant->fel_restorant->settings['without_background_total']) ? auth()->user()->restorant->fel_restorant->settings['without_background_total'] : 0 ?>

        <div style="color: black !important; background-color: white !important;">
            <p style="font-size: 14pt !important; font-weight: 700;" class="mb-0 p-0">FACTURA</p>
            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0">(CON DERECHO A CRÉDITO FISCAL)</p>
            
            @if(auth()->user()->restorant->fel_restorant->is_unipersonal)
                <p style="font-size: 14pt !important; font-weight: 700;" class="mb-0 p-0">{{ auth()->user()->restorant->name }}</p>
                <p style="font-size: {{ $font_size }}pt !important; font-weight: 500; color: black;" class="mb-0 p-0">De: @{{ invoice? invoice.razonSocialEmisor:"" }}</p>
            @else
                <p style="font-size: 14pt !important; font-weight: 700; color: black;" class="mb-0 p-0">@{{ invoice? invoice.razonSocialEmisor:"" }}</p>
            @endif
            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0"><b>@{{ invoice? ((invoice.codigoSucursal == 0) ? "CASA MATRIZ" : ('SUCURSAL ' + invoice.codigoSucursal)) :"" }}</b></p>
            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0">@{{ invoice? (invoice.numeroPuntoVenta? invoice.numeroPuntoVenta:"No. Punto Venta 0") : "" }}</p>
            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0">@{{ invoice? invoice.direccion:"" }}</p>
            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0">Teléfono: @{{ invoice? invoice.telefonoEmisor:"" }}</p>
            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500; text-transform:uppercase;" class="m-0 p-0">@{{ invoice? invoice.municipio:"" }}</p>
            <hr style="margin-top: 5px; margin-bottom: 5px;">
            <div class="row">
                <div class="col-5">
                    <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0 text-left"><b>NIT: </b></p>
                </div>
                <div class="col">
                    <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0 text-left">@{{ invoice? invoice.nitEmisor:"" }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0 text-left"><b>Nº FACTURA: </b></p>
                </div>
                <div class="col">
                    <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0 text-left">@{{ invoice? invoice.numeroFactura:"" }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0 text-left"><b>COD. AUTORIZACIÓN: </b></p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p style="font-size: {{ $font_size }}pt !important; font-weight: 500; overflow-wrap: break-word;" class="m-0 p-0 text-left">@{{ invoice? invoice.cuf:"" }}</p>
                </div>
            </div>
            
            {{-- <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0"><b>C‚àö√¨D. AUTORIZACI‚àö√¨N</b></p>
            <p class="m-0 p-0" style="font-size: {{ $font_size }}pt !important; font-weight: 500; overflow-wrap: break-word;">@{{ invoice? invoice.cuf:"" }}</p> --}}
            <hr style="margin-top: 5px; margin-bottom: 5px;">
            <div class="row" style="color: black;">
                <div class="col">
                    <div class="row">
                        <div class="col-5">
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0 text-left"><b>Razón Social:</b></p>
                        </div>
                        <div class="col">
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0 text-left">@{{ invoice? invoice.nombreRazonSocial:"" }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0 text-left"><b>NIT/CI/CEX:</b></p>
                        </div>
                        <div class="col">
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0 text-left">@{{ invoice? invoice.numeroDocumento:"" }} @{{ invoice? invoice.complemento:"" }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0 text-left"><b>Cod. Cliente:</b></p>
                        </div>
                        <div class="col">
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0 text-left">@{{ invoice? invoice.codigoCliente:"" }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 700;" class="m-0 p-0 text-left"><b>Fecha Emisión:</b></p>
                        </div>
                        <div class="col">
                            <p style="font-size: {{ $font_size }}pt !important; font-weight: 500;" class="m-0 p-0 text-left">@{{ invoice? invoice.fechaEmision:"" }}</p>
                        </div>
                    </div>
                    
                </div>
            </div>
            <hr style="margin-top: 5px; margin-bottom: 5px;">
        </div>
    </center>
    <div class="w-100" style="background-color: white !important;">
        <p style="font-size: {{ $font_size }}pt !important; font-weight: 700; color: black;" class="m-0 p-0 text-center">DETALLE</p>
        <table class="w-100" style="font-size: {{ $font_size }}pt !important; color: black; background-color: white !important;">
            <thead>
                <tr>
                    <th style="width:80% !important; " scope="col"></th>
                    <th style="width:10% !important; padding-right: 2px;" scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr style="font-size: 9pt !important;"  v-for="item in (invoice?invoice.detalles:[])">
                    <td> <span style="font-weight: 600;"> @{{ item.codigoProducto }} - @{{ item.descripcion }}</span> <br>
                        @{{ item.cantidad.toFixed(2) }} X @{{ item.precioUnitario.toFixed(2) }} - @{{ item.descuento?item.descuento.toFixed(2):'0.00' }}
                    </td>
                    <td style="padding-right: 2px; vertical-align:bottom;" class="text-right">@{{ splitBs(formatDecimal(formatPrice(item.subTotal))) }}</td>
                </tr>
                <tr style="border-top: 1px solid rgba(0, 0, 0, .1);">
                  <td style="text-align:end; text-transform: uppercase;" class="px-1 w-70">{{ __('Subtotal ') }} Bs</td>
                  <td class="w-30 text-right text-bottom">@{{ invoice?splitBs(formatDecimal(formatPrice((invoice.montoTotal*1).toFixed(2)))):"" }}</td>
                </tr>
                
                <tr class="blockDelivery">
                    <td style="text-align:end; text-transform: uppercase;" class="px-1 w-70">{{ __('Discount') }} Bs</td>
                    <td class="w-30 text-right">@{{ invoice? (invoice.descuentoAdicional? splitBs(formatDecimal(formatPrice((invoice.descuentoAdicional*1).toFixed(2)))) : splitBs(formatDecimal(formatPrice(0)))):splitBs(formatDecimal(formatPrice(0))) }}</td>
                </tr>
                <tr class="blockDelivery">
                    <td style="text-align:end; text-transform: uppercase;" class="px-1 w-70">{{ __('Total') }} Bs</td>
                    <td class="w-30 text-right">@{{ invoice?splitBs(formatDecimal(formatPrice((invoice.montoTotal*1).toFixed(2)))):"" }}</td>
                </tr>
                <tr class="blockDelivery">
                    <td style="text-align:end; text-transform: uppercase;" class="px-1 w-70">{{ __('Monto Gift Card') }} Bs</td>
                    <td class="w-30 text-right" style="padding-right: 4px;">@{{ invoice&&invoice.montoGiftCard>0?splitBs(formatDecimal(formatPrice((invoice.montoGiftCard*1).toFixed(2)))):"0.00 " }}</td>
                </tr>
                <tr class="blockDelivery">
                    <th style="text-align:end; text-transform: uppercase;" class="px-1 w-70">{{ __('Monto a Pagar') }} Bs</th>
                    <th class="w-30 text-right">@{{ invoice?splitBs(formatDecimal(formatPrice((invoice.montoTotal*1).toFixed(2)))):"" }}</th>
                </tr>
                <tr class="blockDelivery">
                    <th style="text-align:end; text-transform: uppercase;" class="px-1 w-70">{{ __('Base Crédito Fiscal') }} Bs</th>
                    <th class="w-30 text-right">@{{ invoice?splitBs(formatDecimal(formatPrice((invoice.montoTotalSujetoIva*1).toFixed(2)))):"" }}</th>
                </tr>
            </tbody>
        </table>
        <table class="w-100" style="font-size: {{ $font_size }}pt !important; color:black;">
            <tbody>
                <tr>
                    <th></th>
                    <th class="px-1 w-70"></th>
                    <td class="w-30  text-right"></td>
                </tr>
                <tr>
                    <th></th>
                    <td class="px-1" colspan="2">SON: @{{ invoice? (invoice.montoLiteral? invoice.montoLiteral : ""):"" }}</td>
                </tr>
            </tbody>
        </table>
        
        <hr style="margin-top: 5px; margin-bottom: 5px;">
    </div>
    <center style="background-color: white !important;">
        <div style="color: black !important; background-color: white !important;">
            <p style="font-size: 8pt !important; font-weight: 500;" class="m-0 p-0 text-center">ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY</p>
            <p style="font-size: 8pt !important; font-weight: 500;" class="m-0 py-2 text-center">@{{ invoice? invoice.leyenda:"" }}</p>
            <p style="font-size: 8pt !important; font-weight: 500;" class="m-0 p-0 text-center">@{{ invoice? ((invoice.tipoEmision == 'En Linea')? "\"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea\"": "\"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido fuera de línea, verifique su envío con su proveedor o en la página web www.impuestos.gob.bo\""):"" }}</p>
            
            {{-- <img :src=" 'https://api.qrserver.com/v1/create-qr-code/?ecc=M&size=150x150&data='+(invoice? encodeURIComponent(invoice.url_sin):'')" class="image mr-3" alt=""/> --}}
            <div style="page-break-inside: avoid; padding-top: 5px;" class="row">
                <div class="w-100 px-3">
                    <div style="margin: 10px; width:3cm; height:3cm;" id="qrcode"></div>
                </div>
            </div>
            <div class="py-1">
                <p style="font-size: 12pt; font-weight: 600; padding:0px; margin-bottom: 0px !important;">@{{ invoice ? invoice.short_pdf_url : "" }}</p>
                <p style="font-size: 10pt; font-weight: 500;">Sistema de Facturación <span style="font-weight: 600">emizor.com</span></p>
            </div>
        </div>
    </center>  
</div>

