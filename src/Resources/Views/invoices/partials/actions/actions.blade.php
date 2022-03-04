@if($invoice->codigoEstado == 690)
  <button data-toggle="modal" onclick="verAnularFactura({{ $invoice->order_id }})" class="btn btn-sm " value="anular" /> Anular</button>
@endif  