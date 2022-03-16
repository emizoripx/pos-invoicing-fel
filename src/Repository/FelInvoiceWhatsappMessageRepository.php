<?php

namespace EmizorIpx\PosInvoicingFel\Repository;

use EmizorIpx\PosInvoicingFel\Models\FelInvoiceWhatsappMessage;

class FelInvoiceWhatsappMessageRepository {


    public function create( $data ){
        return FelInvoiceWhatsappMessage::create($data);
    }

    public function update( $felwhatsapp_id, $data ){

        return FelInvoiceWhatsappMessage::whereId( $felwhatsapp_id )->update($data);

    }

}