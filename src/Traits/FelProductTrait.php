<?php

namespace EmizorIpx\PosInvoicingFel\Traits;

use EmizorIpx\PosInvoicingFel\Models\FelProduct;

trait FelProductTrait {

    public function fel_product(){
        return $this->hasOne( FelProduct::class, 'item_id', 'id' );
    }

}