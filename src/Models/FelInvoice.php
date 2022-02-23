<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FelInvoice extends Model
{
    protected $table = 'fel_invoices';

    protected $guarded = [];

    protected $casts = [
        'detalles' => 'array'
    ];

    public function setCodigoClienteAttribute($value){
        $this->attributes['codigoCliente'] = 'COD-2';
    }
}
