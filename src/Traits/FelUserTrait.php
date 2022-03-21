<?php

namespace EmizorIpx\PosInvoicingFel\Traits;

use EmizorIpx\PosInvoicingFel\Models\FelProduct;
use EmizorIpx\PosInvoicingFel\Models\FelUser;

trait FelUserTrait {

    public function fel_user(){
        return $this->hasOne( FelUser::class, 'user_id', 'id' );
    }

}