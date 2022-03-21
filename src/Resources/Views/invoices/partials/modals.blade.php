<div class="modal fade modal-xl" id="modal-order-details" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-l modal-dialog-centered" style="max-width:1140px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-order"></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <h3 id="restorant-name"><h3>
                        <p id="restorant-address"></p>
                        <p id="restorant-info"></p>
                        <h4 id="client-name"><h4>
                        <p id="client-info"></p>
                        <h4>Invoice</h4>
                        <p>
                            <ol id="order-items">
                            </ol>
                        </p>
                        <h4 id="delivery-price"><h4>
                        <h4>Total<h4>
                        <p id="total-price"></p>
                    </div>
                    <div class="col-md-5">
                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner') || auth()->user()->hasRole('client'))
                        <div class="card">
                            <!-- Card header -->
                            <div class="card-header">
                            <!-- Title -->
                                <h5 class="h3 mb-0">{{ __("Status History")}}</h5>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="timeline timeline-one-side" id="status-history" style="height: 240px; overflow-y: scroll" data-timeline-content="axis" data-timeline-axis-style="dashed">
                            </div>
                        </div>
                        @endif
                        @if(auth()->user()->hasRole('driver'))
                        <div class="card card-status-history-driver">
                            <!-- Card header -->
                            <div class="card-header">
                            <!-- Title -->
                                <h5 class="h3 mb-0">{{ __("Status History")}}</h5>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="timeline timeline-one-side" id="status-history" style="height: 240px; overflow-y: scroll;" data-timeline-content="axis" data-timeline-axis-style="dashed">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="modal-rate-restaurant" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-item">{{ __('Your overall rating') }}</h3>
                <button type="button" class="btn-close bg-warning" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="post" action="{{ route('rate.order', isset($invoice)?$invoice:"") }}">
                        @csrf

                        <input type="hidden" id="rating_value" name="ratingValue">
                        <section class='rating-widget'>
                        <!-- Rating Stars Box -->
                        <div class='rating-stars text-center'>
                            <ul id='stars'>
                            <li class='star' title='Poor' data-value='1'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' title='Fair' data-value='2'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' title='Good' data-value='3'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' title='Excellent' data-value='4'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' title='WOW!!!' data-value='5'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            </ul>
                        </div>
                        <div class='success-box' id="success-box-ratings">
                            <div class='clearfix'></div>
                            <img alt='tick image' width='32' src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K'/>
                            <div class='text-message'></div>
                            <div class='clearfix'></div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary my-4" id="save-ratings">{{ __('Save') }}</button>
                        </div>
                        </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-time-to-prepare" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-item">{{ __('Invoice time to prepare in minutes') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                    <form role="form" method="GET" id="form-time-to-prepare" action="">
                        <div class="form-group">
                            <input type="hidden" name="time_to_prepare" id="time_to_prepare"/>
                            @for($i=5; $i<=150; $i+=5)
                                <button type="button" value="{{ $i }}" class="btn btn-outline-primary btn-time-to-prepare">{{ $i }}</button>
                            @endfor
                        </div>
                        <div class="text-center">
                            <button type="submit" id="btn-submit-time-prepare" class="btn btn-primary my-4" id="save-ratings">{{ __('Save') }}</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-order-item-count" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-item">{{ __('Quantity') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                   
                </div>
            </div>
        </div>
    </div>
</div>


<!-- POS invoice Modal -->
<div class="modal  fade " id="modalPOSInvoiceView" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" style="overflow: scroll;">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="e-modal-title" id="modal-title-default">{{ __('POS Invoice')}}</h6>
                <button type="button" class="e-btn-close btn-warning" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">

                <div id="posReciptInvoiceView" style="background-color: #FFF;" >
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
                            <div class="row">
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
                    <div class="table-responsive w-100">
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
                            {{-- <img :src=" 'https://api.qrserver.com/v1/create-qr-code/?ecc=M&size=150x150&data='+(invoice? encodeURIComponent(invoice.url_sin):'')" class="image mr-3" alt=""/> --}}
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
</div>
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
