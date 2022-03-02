<?php

namespace EmizorIpx\PosInvoicingFel\Utils;

class Parametrics {

    const MOTIVOS_ANULACION = 'revocation-reason';
    const UNIDADES = 'units';
    const METODO_PAGOS = 'payments-methods';
    const TIPOS_DOCUMENTO_IDENTIDAD = 'payments-methods';


    public static function getTableName($type){
        switch ($type) {
            case static::MOTIVOS_ANULACION:
                return 'fel_revocation_reasons';
                break;
            
            case static::UNIDADES:
                return 'fel_units';
                break;
            
            case static::METODO_PAGOS:
                return 'fel_payment_methods';
                break;
            
            case static::TIPOS_DOCUMENTO_IDENTIDAD:
                return 'fel_identity_document_types';
                break;
            
        }
    }

}