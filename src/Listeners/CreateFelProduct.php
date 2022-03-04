<?php

namespace EmizorIpx\PosInvoicingFel\Listeners;

use EmizorIpx\PosInvoicingFel\Models\FelProduct;
use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use stdClass;

class CreateFelProduct
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
        \Log::debug("Capture Events >>>>>>>>>>>>>> ");

        \Log::debug($event->item->name);

        $str = substr($event->item->name, 0, 3);
        $time = time();

        // $event->item->codigoProducto = strtoupper($str) . '-'. strval($time);
        // $event->item->save();

        $codigo_actividad = \DB::table('fel_sin_products')->where('restorant_id', $event->item->category->restorant_id)->where('codigo', $event->codigoProductoSin)->pluck('codigoActividad')->first();
        \Log::debug("Codigo Actividad Economica >>>>>> " . $codigo_actividad);

        $new = new FelProduct();
        $new->restorant_id = $event->item->category->restorant_id;
        $new->item_id = $event->item->id;
        $new->codigoProducto = strtoupper($str) . '-'. strval($time);
        $new->codigoUnidad = $event->codigoUnidad;
        $new->codigoProductoSin = $event->codigoProductoSin;
        $new->codigoActividadEconomica = $codigo_actividad;

        $new->save();

    }
}
