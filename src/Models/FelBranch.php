<?php

namespace EmizorIpx\PosInvoicingFel\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FelBranch extends Model
{
    use HasFactory;

    protected $table = 'fel_branches';

    protected $guarded = [];
}
