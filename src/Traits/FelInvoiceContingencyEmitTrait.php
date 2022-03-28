<?php

namespace EmizorIpx\PosInvoicingFel\Traits;

use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceRepository;
use EmizorIpx\PosInvoicingFel\Services\Invoices\FelInvoiceService;

trait FelInvoiceContingencyEmitTrait {


    public function emitInContingency(){

        if ( $this->cuf != null){
            \Log::debug("La Factura" . $this->numeroFactura . "ya fue emitida");
        }

        $fel_token = FelToken::where('restorant_id', $this->restorant_id)->first();

        $fel_invoice_repo = new FelInvoiceRepository();

        if( empty($fel_token) ){
            // throw new Exception('No se tiene credenciales configuradas para emitir Facturas');
            \Log::debug('No se tiene credenciales configuradas para emitir Facturas');
        }

        $invoice_service = new FelInvoiceService( $fel_token->host );

        $invoice_service->setAccessToken($fel_token->access_token);

        $invoice_service->buildData($this);

        $invoice_service->sendToFel();

        $fel_invoice_repo->parseResponseToSave( $invoice_service->getResponse() );

        $fel_invoice_repo->update($this);

    }

}