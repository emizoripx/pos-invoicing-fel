<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use EmizorIpx\PosInvoicingFel\Services\Whatsapp\WhatsappService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FelInvoice extends Model
{
    protected $table = 'fel_invoices';

    protected $guarded = [];

    protected $casts = [
        'detalles' => 'array',
        'errores' => 'array'
    ];

    public function setCodigoClienteAttribute($value){
        $this->attributes['codigoCliente'] = 'COD-' . $this->numeroDocumento ;
    }

    public function whatsapp_service(){
        return new WhatsappService($this);
    }
}
