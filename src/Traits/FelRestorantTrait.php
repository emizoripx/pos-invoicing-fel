<?php

namespace EmizorIpx\PosInvoicingFel\Traits;

use EmizorIpx\PosInvoicingFel\Models\FelProduct;
use EmizorIpx\PosInvoicingFel\Models\FelRestorant;

trait FelRestorantTrait {

    public function fel_restorant(){
        return $this->hasOne( FelRestorant::class , 'restorant_id', 'id' );
    }

    public function restoareas() {

        return $this->hasMany(\App\RestoArea::class, 'restaurant_id', 'id')->when( auth()->user()->hasRole('staff'), function( $query ) {

            \Log::debug('is staff: ' . (auth()->user()->hasRole('staff') ? 'SI' : 'NO'));
            $fel_branch = auth()->user()->fel_branch();

            return $query->where('branch_id', $fel_branch->id);
        });
    }

}
