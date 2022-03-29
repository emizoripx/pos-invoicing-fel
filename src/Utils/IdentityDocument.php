<?php

namespace EmizorIpx\PosInvoicingFel\Utils;

class IdentityDocument {

    const NIT = 'NIT';
    const CI = 'CI';
    const CEX = 'CEX';
    const PAS = 'PAS';
    const OD = 'OD';

    public static function getIdentityDocumentCode($param){

        switch ($param) {
            case static::CI:
                return 1;
                break;
            case static::CEX:
                return 2;
                break;
            case static::PAS:
                return 3;
                break;
            case static::OD:
                return 4;
                break;
            case static::NIT:
                return 5;
                break;
            
            default:
                return 4;
                break;
        }

    }

}