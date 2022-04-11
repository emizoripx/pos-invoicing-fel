<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use EmizorIpx\PosInvoicingFel\Services\Restorants\RestorantService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FelRestorant extends Model
{
    protected $table = 'fel_restorants';

    protected $guarded = [];

    protected $casts = [
        'settings' => 'array',
    ];

    public function service(){
        return new RestorantService($this);
    }
    
    public function fel_products(){
        return $this->hasMany( FelProduct::class, 'restorant_id', 'restorant_id' );
    }

    public function fel_token(){
        return $this->hasOne( FelToken::class, 'restorant_id', 'restorant_id');
    }

}
