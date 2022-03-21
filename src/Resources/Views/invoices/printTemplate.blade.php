    <style>
        .row {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        .col-th{
            display: flex;
            flex-direction:column;
            justify-content:end !important;
            width: 100%;
        }
        .col-td{
            display: flex;
            flex-direction:column;
            justify-content: start;
        }


    </style>
    <div id="templateInvoice">
        <center>
            <div>
                <p style="font-size: 10pt !important;" class="m-0 p-0"><b>FACTURA</b></p>
                <p style="font-size: 10pt !important;" class="mb-0 p-0"><b>CON DERECHO A CRÉDITO
                        FISCAL</b></p>
                {{-- @if ($is_unipersonal)
                    <p style="font-size: 10pt !important;" class="mb-0 p-0">
                        {{ auth()->user()->restorant->name }}</p>
                    <p style="font-size: 10pt !important;" class="mb-0 p-0">De: {{ $invoice ? $invoice->razonSocialEmisor : "" }}
                    </p>
                @else --}}
                    <p style="font-size: 10pt !important;" class="mb-0 p-0">{{ $invoice ? $invoice->razonSocialEmisor : "" }}</p>
                {{-- @endif --}}
                <p style="font-size: 10pt !important;" class="m-0 p-0"><b>{{ $invoice ? (($invoice->codigoSucursal == 0) ? "Casa Matriz" : ('Sucursal N. ' + $invoice->codigoSucursal)) : "" }}</b>
                </p>
                <p style="font-size: 10pt !important;" class="m-0 p-0"><b>{{ $invoice ? ($invoice->numeroPuntoVenta ? $invoice->numeroPuntoVenta : "No. Punto Venta 0") : "" }}</b>
                </p>
                <p style="font-size: 10pt !important;" class="m-0 p-0">{{ $invoice ? $invoice->direccion : "" }}</p>
                <p style="font-size: 10pt !important;" class="m-0 p-0">Teléfono:
                    {{ $invoice ? $invoice->telefonoEmisor : "" }}</p>
                <p style="font-size: 10pt !important;" class="m-0 p-0">{{ $invoice ? $invoice->municipio : "" }}</p>
                <hr>
                <p style="font-size: 10pt !important;" class="m-0 p-0"><b>NIT</b></p>
                <p style="font-size: 10pt !important;" class="m-0 p-0">{{ $invoice ? $invoice->nitEmisor : "" }}</p>
                <p style="font-size: 10pt !important;" class="m-0 p-0"><b>FACTURA Nº</b></>
                <p style="font-size: 10pt !important;" class="m-0 p-0">{{ $invoice ? $invoice->numeroFactura : "" }}</p>
                <p style="font-size: 10pt !important;" class="m-0 p-0"><b>CÓD. AUTORIZACIÓN</b></p>
                <p class="m-0 p-0" style="font-size: 10pt !important;">{{ $invoice ? $invoice->cuf : "" }}</p>
                <hr>
                <div class="row">
                    <div class="col">
                        <p style="font-size: 10pt !important; text-align:right;"><b>NOMBRE/RAZÓN SOCIAL: </b></p>
                        <p style="font-size: 10pt !important; text-align:right;">
                            <b>NIT/CI/CEX:</b>
                        </p>
                        <p style="font-size: 10pt !important; text-align:right;"><b>COD.
                                CLIENTE:</b></p>
                        <p style="font-size: 10pt !important; text-align:right;"><b>F.
                                EMISIÓN:</b></p>
                    </div>
                    <div class="col">
                        <p style="font-size: 10pt !important; text-align:left; padding-left:10px;">
                            {{ $invoice->nombreRazonSocial }}</p>
                        <p style="font-size: 10pt !important; text-align:left;  padding-left:10px;">
                            {{ $invoice ? $invoice->numeroDocumento : "" }} {{ $invoice ? $invoice->complemento : "" }}</p>
                        <p style="font-size: 10pt !important; text-align:left;  padding-left:10px;" class="m-0 p-0 text-left">
                            {{ $invoice ? $invoice->codigoCliente : "" }}</p>
                        <p style="font-size: 10pt !important; text-align:left;  padding-left:10px;" class="m-0 p-0 text-left">
                            {{ $invoice ? $invoice->fechaEmision : "" }}</p>
                    </div>
                </div>
                <hr>
            </div>
        </center>
        <div style="width:100%;">
            <table style="width:100%;" >
                <thead>
                    <tr>
                        <th style="width:50%;" scope="col">{{ __('Item') }}</th>
                        <th style="width:25%; " scope="col">{{ __('Qty') }}</th>
                        <th style="width:25%; " scope="col">{{ __('Subtotal') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->detalles as  $item)
                        
                    <tr>
                        <td >{{ $item['descripcion'] }}</td>
                        <td style="text-align:end;">{{ $item['cantidad'] }}</td>
                        <td style="text-align:end;">{{ $item['subTotal'] }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th style="text-align: start;" colspan="2">{{ __('Subtotal.') }}</th>
                        <td style="text-align:end;">{{ $invoice ? ($invoice->montoTotal * 1) : "" }}</td>
                    </tr>

                    <tr class="blockDelivery">
                        <th></th>
                        <th class="p-1 w-70">{{ __('Discount') }}</th>
                        <td style="text-align:end;">{{ $invoice ? ($invoice->descuentoAdicional ? $invoice->descuentoAdicional * 1 : 0) : 0 }}</td>
                    </tr>
                    <tr class="blockDelivery">
                        <th></th>
                        <th class="p-1 w-70">{{ __('Total') }}</th>
                        <th style="text-align:end;">{{ $invoice ? $invoice->montoTotal * 1 : "" }}</th>
                    </tr>
                    @if($invoice->montoGiftCard > 0)
                        
                    <tr class="blockDelivery">
                        <th></th>
                        <th class="p-1 w-70">{{ __('Monto Gift Card') }}</th>
                        <th style="text-align:end;">{{ $invoice ? $invoice->montoGiftCard * 1 : "" }}</th>
                    </tr>
                    @endif
                </tbody>
            </table>
            <table style="width: 100%;" >
                <tbody>
                    <tr>
                        <th style="text-align:start;">MONTO A PAGAR Bs</th>
                        <th style="text-align:end;">{{ $invoice ? $invoice->montoTotal * 1 : "" }}</th>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <th style="text-align:start;">{{ __('Importe Base Crédito Fiscal.') }}</th>
                        <td style="text-align:end;">{{ $invoice ? $invoice->montoTotalSujetoIva * 1 : "" }}</td>
                    </tr>
                    <tr>
                        <td>SON: {{ $invoice ? ($invoice->montoLiteral ? $invoice->montoLiteral : "") : "" }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
        <hr>
        <center>
            <div>
                <p style="font-size: 8pt !important;" class="m-0 p-0 text-center">ESTA FACTURA CONTRIBUYE
                    AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY</p>
                <p style="font-size: 8pt !important;" class="m-0 py-2 text-center">{{ $invoice ? $invoice->leyenda : "" }}
                </p>
                <p style="font-size: 8pt !important;" class="m-0 p-0 text-center">{{ $invoice ? (($invoice->tipoEmision == 'En Linea') ? "\"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea\"" : "\"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido fuera de línea, verifique su envío con su proveedor o en la página web www.impuestos.gob.bo\"") : "" }}
                </p>
                <br />
                <img src="https://api.qrserver.com/v1/create-qr-code/?ecc=M&size=150x150&data={{ $invoice->url_sin }}"
                    class="image mr-3" style="margin-bottom: 30px;" alt="" />
            </div>
        </center>
    </div>
