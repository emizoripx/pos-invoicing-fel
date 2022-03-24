<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FelContingencyFile extends Model
{
    const STATUS_PROCESSED = 'processed';
    const STATUS_PROCESSING = 'processing';
    const STATUS_PENDING = 'pending';

    protected $table = 'fel_contingency_files';

    protected $guarded = [];

    public function canBeProcessed()
    {
        return $this->status == static::STATUS_PROCESSING;
    }

}
