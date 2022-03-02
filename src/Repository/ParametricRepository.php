<?php

namespace EmizorIpx\PosInvoicingFel\Repository;

use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Utils\Parametrics;
use stdClass;

class ParametricRepository {

    public function get($type){

        $parametrics = \DB::table(Parametrics::getTableName($type))->where('is_active')->get();

        return $parametrics;

    }
}