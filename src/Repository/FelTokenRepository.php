<?php

namespace EmizorIpx\PosInvoicingFel\Repository;

use EmizorIpx\PosInvoicingFel\Models\FelToken;

class FelTokenRepository {


    public function getCredentials($restorant_id){

        $fel_token = FelToken::where('restorant_id', $restorant_id)->select('access_token', 'host')->first();

        \Log::debug($fel_token);

        return $fel_token;

    }

}