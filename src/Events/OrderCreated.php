<?php

namespace EmizorIpx\PosInvoicingFel\Events;

use App\Models\Company;
use App\Models\Invoice;
use App\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $fel_data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( Order $order, array $fel_data )
    {
        $this->order = $order;
        $this->fel_data = $fel_data;
    }
}
