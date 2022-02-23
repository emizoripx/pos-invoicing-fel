<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use Illuminate\Database\Eloquent\Model;

class FelToken extends Model
{
    protected $table = 'fel_tokens';

    protected $guarded = [];


    public function getAccessToken(){
        return $this->access_token;
    }

    public function getHost(){
        return $this->host;
    }

}
