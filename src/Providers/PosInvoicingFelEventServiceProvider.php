<?php

namespace EmizorIpx\PosInvoicingFel\Providers ;

use EmizorIpx\PosInvoicingFel\Events\OrderCreated;
use EmizorIpx\PosInvoicingFel\Events\OrderUpdated;
use EmizorIpx\PosInvoicingFel\Events\ProductCreated;
use EmizorIpx\PosInvoicingFel\Events\ProductUpdated;
use EmizorIpx\PosInvoicingFel\Listeners\CreateFelInvoice;
use EmizorIpx\PosInvoicingFel\Listeners\CreateFelProduct;
use EmizorIpx\PosInvoicingFel\Listeners\UpdateFelInvoice;
use EmizorIpx\PosInvoicingFel\Listeners\UpdateFelProduct;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class PosInvoicingFelEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderCreated::class => [
            CreateFelInvoice::class
        ],
        OrderUpdated::class => [
            UpdateFelInvoice::class
        ],
        ProductCreated::class => [
            CreateFelProduct::class
        ],
        ProductUpdated::class => [
            UpdateFelProduct::class
        ],
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
