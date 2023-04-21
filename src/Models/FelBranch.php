<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use App\RestoArea;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FelBranch extends Model
{
    use HasFactory;

    protected $table = 'fel_branches';

    protected $guarded = [];


    public function users() {

        return $this->belongsToMany( User::class, 'user_fel_branch', 'branch_id', 'user_id');
    }

    public function restoareas() {

        return $this->hasMany( RestoArea::class, 'branch_id', 'id' );
    }
}
