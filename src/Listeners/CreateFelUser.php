<?php

namespace EmizorIpx\PosInvoicingFel\Listeners;

use EmizorIpx\PosInvoicingFel\Models\FelUser;

class CreateFelUser
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
        \Log::debug("Capture Events FEL User >>>>>>>>>>>>>> ");

        \Log::debug($event->user->id . " - " . $event->branch_code);

        $fel_user = FelUser::create([
            'user_id' => $event->user->id,
            'codigo_sucursal' => $event->branch_code,
        ]);

    }
}
