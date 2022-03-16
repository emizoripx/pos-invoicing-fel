<?php

namespace EmizorIpx\PosInvoicingFel\Services\Restorants;

use EmizorIpx\PosInvoicingFel\Models\FelRestorant;

class RestorantService {

    protected $fel_restorant;

    public function __construct( FelRestorant $fel_restorant )
    {

        $this->fel_restorant = $fel_restorant;
        
    }


    public function getNextNumber() {

        $last_number = $this->fel_restorant->last_invoice_number_applied;

        $next_number = $last_number + 1;
        
        $this->fel_restorant->last_invoice_number_applied = $next_number;
        $this->fel_restorant->save();

        return $next_number;

    }
    public function getPreviousNumber() {

        $last_number = $this->fel_restorant->last_invoice_number_applied;

        $previous = $last_number == 0 ? 0 : $last_number - 1;

        $this->fel_restorant->last_invoice_number_applied = $previous;
        $this->fel_restorant->save();

        return $previous;

    }

}