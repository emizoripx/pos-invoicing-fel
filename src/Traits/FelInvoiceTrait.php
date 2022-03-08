<?php

namespace EmizorIpx\PosInvoicingFel\Traits;

use EmizorIpx\PosInvoicingFel\Models\FelInvoice;

trait FelInvoiceTrait {

    public function fel_invoice(){
        return $this->hasOne( FelInvoice::class, 'order_id', 'id' );
    }

}