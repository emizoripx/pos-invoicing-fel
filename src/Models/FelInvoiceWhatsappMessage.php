<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use EmizorIpx\WhatsappMessages\Traits\WhatsappMessageTrait;
use Illuminate\Database\Eloquent\Model;

class FelInvoiceWhatsappMessage extends Model
{
    use WhatsappMessageTrait;

    protected $table = 'fel_invoice_whatsapp_messages';

    protected $guarded = [];

}
