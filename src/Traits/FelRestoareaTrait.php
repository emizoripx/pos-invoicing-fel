<?php

namespace EmizorIpx\PosInvoicingFel\Traits;

use EmizorIpx\PosInvoicingFel\Models\FelBranch;

trait FelRestoareaTrait {

    public function branch() {

        return $this->belongsTo(FelBranch::class, 'branch_id', 'id');
    }
}
