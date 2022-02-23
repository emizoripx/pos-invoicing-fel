<?php

namespace EmizorIpx\PosInvoicingFel\Listeners;

use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use stdClass;

class CreateFelInvoice
{
    protected $fel_invoice_repo;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct( FelInvoiceRepository $fel_invoice_repo )
    {
        $this->fel_invoice_repo = $fel_invoice_repo;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        \Log::debug("Capture Events >>>>>>>>>>>>>> ");

        \Log::debug($event->order->items);

        $this->fel_invoice_repo->prepareData($event->order, $event->fel_data);
        $this->fel_invoice_repo->prepareDetailsData($event->order->items);
        
        $this->fel_invoice_repo->create();

    }
}
