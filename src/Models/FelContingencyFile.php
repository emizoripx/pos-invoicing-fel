<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use EmizorIpx\PosInvoicingFel\Utils\ContingencyFileStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FelContingencyFile extends Model
{

    protected $table = 'fel_contingency_files';

    protected $guarded = [];

    protected $casts = [
        'errors' => 'array'
    ];

    public function canBeProcessed()
    {
        return $this->status == ContingencyFileStatus::STATUS_PROCESSING;
    }

    public function cafc_code (){
        return $this->hasOne(FelCafcCode::class, 'id', 'cafc_id');
    }

}
