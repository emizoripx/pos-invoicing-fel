<?php

namespace EmizorIpx\PosInvoicingFel\Utils;

use EmizorIpx\PosInvoicingFel\Models\FelIdentityDocumentType;
use EmizorIpx\PosInvoicingFel\Models\FelPaymentMethod;
use EmizorIpx\PosInvoicingFel\Models\FelRevocationReason;
use EmizorIpx\PosInvoicingFel\Models\FelSinProduct;
use EmizorIpx\PosInvoicingFel\Models\FelUnit;

class Parametrics {

    const MOTIVOS_ANULACION = 'revocation-reason';
    const UNIDADES = 'units';
    const METODO_PAGOS = 'payments-methods';
    const TIPOS_DOCUMENTO_IDENTIDAD = 'identity-document-types';
    const SIN_PRODUCTS = 'sin-products';


    public static function getAll(){
        return [
            SELF::METODO_PAGOS,
            SELF::UNIDADES,
            SELF::MOTIVOS_ANULACION,
            SELF::TIPOS_DOCUMENTO_IDENTIDAD
        ];
    }

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
            case static::SIN_PRODUCTS:
                return 'fel_sin_products';
                break;
            
        }
    }

    public static function getTypeUri($type){

        switch ($type) {
            case static::UNIDADES:
                return 'unidades';
                break;
            case static::MOTIVOS_ANULACION:
                return 'motivos-de-anulacion';
                break;
            case static::METODO_PAGOS:
                return 'metodos-de-pago';
                break;
            case static::TIPOS_DOCUMENTO_IDENTIDAD:
                return 'tipos-documento-de-identidad';
                break;
            case static::SIN_PRODUCTS:
                return 'productos-sin';
                break;
            
        }

    }

    public static function getNameClass($type){

        switch ($type) {
            case static::UNIDADES:
                return FelUnit::class;
                break;
            case static::METODO_PAGOS:
                return FelPaymentMethod::class;
                break;
            case static::TIPOS_DOCUMENTO_IDENTIDAD:
                return FelIdentityDocumentType::class;
                break;
            case static::MOTIVOS_ANULACION:
                return FelRevocationReason::class;
                break;
            case static::SIN_PRODUCTS:
                return FelSinProduct::class;
                break;
            
        }

    }

}