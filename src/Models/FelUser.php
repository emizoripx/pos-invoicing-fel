<?php

namespace EmizorIpx\PosInvoicingFel\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FelUser extends Model
{

    protected $table = 'fel_users';

    protected $guarded = [];

    public function user(){
        return $this->hasOne( User::class, 'id', 'user_id' );
    }

    public function fel_branch(){ // Verify after
        return $this->hasOne( FelBranch::class, 'codigo_sucursal', 'codigo_sucursal')->where('restorant_id', $this->user->restorant->id);
    }

}
