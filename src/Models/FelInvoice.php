<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use App\Restorant;
use EmizorIpx\PosInvoicingFel\Services\Whatsapp\WhatsappService;
use EmizorIpx\PosInvoicingFel\Traits\FelInvoiceContingencyEmitTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FelInvoice extends Model
{
    use FelInvoiceContingencyEmitTrait;

    protected $table = 'fel_invoices';

    protected $guarded = [];

    protected $casts = [
        'detalles' => 'array',
        'errores' => 'array'
    ];

    public function setCodigoClienteAttribute($value){
        $this->attributes['codigoCliente'] = 'COD-' . $this->numeroDocumento ;
    }

    public function getFormattedFechaEmisionAttribute(){
        return date('d/m/Y h:i A', strtotime($this->fechaEmision));
    }

    public function whatsapp_service(){
        return new WhatsappService($this);
    }

    public function restorant() {
        return $this->hasOne( Restorant::class, 'id', 'restorant_id');
    }

    public function fel_restorant() {
        return $this->hasOne( FelRestorant::class, 'restorant_id', 'restorant_id');
    }
}
