<?php

namespace EmizorIpx\PosInvoicingFel\Listeners;

use EmizorIpx\PosInvoicingFel\Models\FelProduct;
use EmizorIpx\PosInvoicingFel\Models\FelRestorant;
use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use stdClass;

class CreateFelRestorant
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(  )
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        \Log::debug("Capture Events FELRestorant >>>>>>>>>>>>>> ");

        \Log::debug($event->restorant->name . " - " . $event->restorant->id);

        $fel_restorant = FelRestorant::create([
            'restorant_id' => $event->restorant->id
        ]);

    }
}
