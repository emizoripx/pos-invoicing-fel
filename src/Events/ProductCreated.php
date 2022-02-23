<?php

namespace EmizorIpx\PosInvoicingFel\Events;

use App\Items;
use App\Models\Company;
use App\Models\Invoice;
use App\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $item;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( Items $item )
    {
        $this->item = $item;
    }
}
