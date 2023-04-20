<?php

namespace EmizorIpx\PosInvoicingFel\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use EmizorIpx\PosInvoicingFel\Models\FelBranch;

trait FelUserTrait {

    public function fel_branches() {

        return $this->belongsToMany( FelBranch::class, 'user_fel_branch', 'user_id', 'branch_id' );
    }

    public function fel_branch() {

        return $this->fel_branches->first();
    }

    public function attachBranch( $request ) {

        if( $request->has('branch_id') && ! is_null( $request->branch_id ) && ! $this->hasRole('owner') ) {

            $this->fel_branches()->attach( $request->branch_id );
        }

    }
}
