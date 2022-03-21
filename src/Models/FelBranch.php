<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use EmizorIpx\PosInvoicingFel\Repository\FelBranchRepository;
use Illuminate\Database\Eloquent\Model;

class FelBranch extends Model
{

    protected $table = 'fel_branches';

    protected $guarded = [];

    public static function getAll( $restorant_id ){
        $branch_repo = new FelBranchRepository();

        return $branch_repo->getPluck($restorant_id);
    }

}
