@if($invoice->codigoEstado == 690)
  <button data-toggle="modal" onclick="verAnularFactura({{ $invoice->order_id }})" class="btn btn-sm " value="anular" /> Anular</button>
  @if(isset(auth()->user()->restorant->fel_restorant) && auth()->user()->restorant->fel_restorant->enabled_whatsapp_send )
  
  <button data-toggle="modal" onclick="verEnviarWhatsapp({{ $invoice }})" class="btn btn-sm bg-gradient-primary" value="anular" /> <i class="fa fa-whatsapp fs-6 align-middle"></i> Enviar</button>
  @endif
@endif  