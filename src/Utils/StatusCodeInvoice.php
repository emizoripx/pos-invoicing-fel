<?php

namespace EmizorIpx\PosInvoicingFel\Utils;

class StatusCodeInvoice {

    const ARRAY_FINAL_STATUS = [902,904,690,691,906];
    const ARRAY_FINAL_STATUS_EMIT = [902,904,690];
    const ARRAY_FINAL_STATUS_REVOCATE = [691,906];



    public static function getFinalStatusArray($action){
        switch ($action) {
            case ActionTypes::EMIT:
                \Log::debug("status final EMIT >>>>>>>>>> " .json_encode(static::ARRAY_FINAL_STATUS_EMIT));
                return static::ARRAY_FINAL_STATUS_EMIT;
                break;
            case ActionTypes::REVOCATE:
                \Log::debug("status final REVOCATE >>>>>>>>>> " .json_encode(static::ARRAY_FINAL_STATUS_REVOCATE));
                return static::ARRAY_FINAL_STATUS_REVOCATE;
                break;
            
            default:
            \Log::debug("status final >>>>>>>>>> " .json_encode(static::ARRAY_FINAL_STATUS));
                return static::ARRAY_FINAL_STATUS;
                break;
        }
    }

}