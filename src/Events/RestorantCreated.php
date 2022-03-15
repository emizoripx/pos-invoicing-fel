<?php

namespace EmizorIpx\PosInvoicingFel\Events;

use App\Items;
use App\Models\Company;
use App\Models\Invoice;
use App\Order;
use App\Restorant;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RestorantCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $restorant;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( Restorant $restorant )
    {
        $this->restorant = $restorant;
    }
}
