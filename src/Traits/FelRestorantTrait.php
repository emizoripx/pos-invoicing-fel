<?php

namespace EmizorIpx\PosInvoicingFel\Traits;

use EmizorIpx\PosInvoicingFel\Models\FelProduct;
use EmizorIpx\PosInvoicingFel\Models\FelRestorant;

trait FelRestorantTrait {

    public function fel_restorant(){
        return $this->hasOne( FelRestorant::class , 'restorant_id', 'id' );
    }

}