<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use EmizorIpx\PosInvoicingFel\Repository\ParametricRepository;
use EmizorIpx\PosInvoicingFel\Utils\Parametrics;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FelSinProduct extends Model
{
    protected $table = 'fel_sin_products';

    protected $guarded = [];

    public static function getAll( $restorant_id ){
        $parametrics_repo = new ParametricRepository();

        return $parametrics_repo->getPluck(Parametrics::SIN_PRODUCTS, $restorant_id);
    }

}
