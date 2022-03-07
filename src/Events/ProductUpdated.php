<?php

namespace EmizorIpx\PosInvoicingFel\Events;

use App\Items;
use App\Models\Company;
use App\Models\Invoice;
use App\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $item;

    public $codigoUnidad;

    public $codigoProductoSin;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( Items $item, $codigoUnidad, $codigoProductoSin )
    {
        $this->item = $item;

        $this->codigoUnidad = $codigoUnidad;

        $this->codigoProductoSin = $codigoProductoSin;
    }
}
