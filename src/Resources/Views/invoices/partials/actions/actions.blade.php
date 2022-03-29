@if($invoice->codigoEstado == 690)
  <button data-toggle="modal" onclick="verAnularFactura({{ $invoice->order_id }})" class="btn btn-sm " value="anular" /> Anular</button>
  @if(isset(auth()->user()->restorant->fel_restorant) && auth()->user()->restorant->fel_restorant->enabled_whatsapp_send )
  
  <button data-toggle="modal" onclick="verEnviarWhatsapp({{ $invoice }})" class="btn btn-sm bg-success text-white" value="anular" /> <i class="fa fa-whatsapp fs-6 align-middle"></i> Enviar</button>
  @endif
@elseif(is_null($invoice->codigoEstado))
  <i id="indicatorvalidate_{{ $invoice->id }}" style="display: none" class="fas fa-spinner fa-spin"></i>
  <button id="btn_validate_{{ $invoice->id }}" onclick="validateStateInvoice({{ $invoice->id }})" class="btn btn-sm bg-primary text-white " value="Validar Estado" /> Validar Estado</button>

@endif  