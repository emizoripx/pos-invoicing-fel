<?php

namespace EmizorIpx\PosInvoicingFel\Providers ;

use EmizorIpx\PosInvoicingFel\Events\OrderCreated;
use EmizorIpx\PosInvoicingFel\Events\ProductCreated;
use EmizorIpx\PosInvoicingFel\Listeners\CreateFelInvoice;
use EmizorIpx\PosInvoicingFel\Listeners\CreateFelProduct;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class PosInvoicingFelEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderCreated::class => [
            CreateFelInvoice::class
        ],
        ProductCreated::class => [
            CreateFelProduct::class
        ]
    ];
    

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
