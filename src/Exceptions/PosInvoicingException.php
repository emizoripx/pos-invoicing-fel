<?php

namespace EmizorIpx\PosInvoicingFel\Exceptions;

use Exception;

class PosInvoicingException extends Exception
{
    public function __construct($msg)
    {
        $finalMessage = 'Errors';

        if ($msg != null) {
            $finalMessage = $msg;
        }

        parent::__construct($finalMessage);
    }
}
