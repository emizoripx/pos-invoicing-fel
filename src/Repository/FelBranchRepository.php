<?php

namespace EmizorIpx\PosInvoicingFel\Repository;

use EmizorIpx\PosInvoicingFel\Models\FelBranch;

class FelBranchRepository {


    public function create( $data ) {

        return FelBranch::create( $data );
    }


    public function update( $branch_id, $data ) {

        return FelBranch::whereId( $branch_id )->update( $data );
    }

    public function upsert( $data ) {

        return FelBranch::upsert($data, ['codigo_sucursal', 'restorant_id'], ['descripcion', 'zona']);
    }
}
