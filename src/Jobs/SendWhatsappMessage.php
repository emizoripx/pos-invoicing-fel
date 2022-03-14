<?php

namespace EmizorIpx\PosInvoicingFel\Jobs;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceRepository;
use EmizorIpx\PosInvoicingFel\Repository\FelTokenRepository;
use EmizorIpx\PosInvoicingFel\Services\Invoices\FelInvoiceService;
use EmizorIpx\PosInvoicingFel\Utils\EmissionTypes;
use EmizorIpx\PosInvoicingFel\Utils\StatusCodeInvoice;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Throwable;

class SendWhatsappMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice ;

    protected $delay_times = [5, 10, 15 ];

    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( FelInvoice $invoice)
    {
        $this->invoice = $invoice;
    }


    public function middleware(){

        return [ (new WithoutOverlapping($this->invoice->id))->releaseAfter(10)]; //Re-intertar luego de 10 seg.

    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{


            \Log::debug("SEND WHATSAPP JOBS INIT >>>>>>>>>>>>>>>>>>>>> #". $this->invoice->numeroFactura . " Telefono: ". $this->invoice->telefonoCliente . " Attempts #". $this->attempts());


            if( is_null($this->invoice->telefonoCliente) || empty($this->invoice->telefonoCliente) ){
                \Log::debug("SEND WHATSAPP JOBS  >>>>>>>>>>>>>> no se encontro numero de telefono");

                $this->fail();
            }

            $response = $this->invoice->whatsapp_service()->sendMessage($this->invoice->telefonoCliente);
            


        } catch( Exception $ex ){
            \Log::debug("SEND WHATSAPP JOBS >>>>>>>>>>>>>>>>>>>>> Log Exception " .$ex->getMessage());

            $attemps_after = $this->delay_times[$this->attempts() - 1];


            \Log::debug("Send Invoice #" . $this->invoice->numeroFactura ." Attempt after of ". $attemps_after . " Seconds");
            $this->release($attemps_after);
        }
    }


    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
        \Log::debug("Ocurrio un Error en realizar la Peticion de Estado Excepción: " . $exception->getMessage());
    }
}
