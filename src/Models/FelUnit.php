<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use EmizorIpx\PosInvoicingFel\Repository\ParametricRepository;
use EmizorIpx\PosInvoicingFel\Utils\Parametrics;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FelUnit extends Model
{

    protected $table = 'fel_units';

    protected $guarded = [];

    public static function getAll(){
        $parametrics_repo = new ParametricRepository();

        return $parametrics_repo->getPluck(Parametrics::UNIDADES);
    }

}
