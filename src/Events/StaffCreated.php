<?php

namespace EmizorIpx\PosInvoicingFel\Events;

use App\Items;
use App\Models\Company;
use App\Models\Invoice;
use App\Order;
use App\Restorant;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StaffCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $branch_code;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( User $user, $branch_code )
    {
        $this->user = $user;

        $this->branch_code = $branch_code;
    }
}
