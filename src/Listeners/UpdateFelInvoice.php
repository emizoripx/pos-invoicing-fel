<?php

namespace EmizorIpx\PosInvoicingFel\Listeners;

use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use stdClass;

class UpdateFelInvoice
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

        \Log::debug($event->order);

        $fel_invoice = $this->fel_invoice_repo->get($event->order->id);

        if(empty($fel_invoice)){
            \Log::debug("No se encontro Fel Invoice para la orden #". $event->order->id);
            return;
        }

        // $this->fel_invoice_repo->prepareData($event->order, $event->fel_data);
        $this->fel_invoice_repo->prepareDetailsData($event->order->items);

        if( $event->order->delivery_price > 0 ){
            $this->fel_invoice_repo->addDeliveryItem($event->order->delivery_price, $event->order->items[0]);
        }
        $fel_invoice->detalles = $this->fel_invoice_repo->getFelInvoiceDetails();
        $fel_invoice->montoTotal = $event->order->order_price;
        $fel_invoice->montoTotalSujetoIva = $event->order->order_price;


        $fel_invoice->save();

    }
}
