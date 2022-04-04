<?php

namespace EmizorIpx\PosInvoicingFel\Jobs;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Notifications\GetStatusInvoiceFailed;
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

use Illuminate\Support\Facades\Notification;

use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Throwable;

class GetInvoiceStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice ;

    protected $action;

    protected $delay_times = [10, 20, 30, 60, 120, 300];
    protected $delay_offline = [1800, 3600, 10800, 18000, 36000,86400];

    public $tries = 6;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( FelInvoice $invoice, $action )
    {
        $this->invoice = $invoice;
        $this->action = $action;
    }


    public function middleware(){

        // return [ (new WithoutOverlapping($this->invoice->id))->releaseAfter(10), (new ThrottlesExceptions(4, 2)) ]; //Re-intertar luego de 10 seg.
        return [ (new WithoutOverlapping($this->invoice->id))->releaseAfter(10)]; //Re-intertar luego de 10 seg.

    }

    // public function backoff()
    // {
    //     // return [10, 60, 120, 300, 600, 1800, 3600, 10800, 18000, 36000, 86400 ];
    //     return [20, 60, 120, 300, 600];
    // // }
    // }

    // public function retryUntil()
    // {
    //     return now()->addMinutes(5);
    // }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle( FelTokenRepository $fel_token_repo)
    {
        try{

            $fel_invoice_repo = new FelInvoiceRepository ();

            \Log::debug("GET INVOICE STATUS JOBS INIT >>>>>>>>>>>>>>>>>>>>> #". $this->invoice->numeroFactura . " Attempts #". $this->attempts());

            $credentials = $fel_token_repo->getCredentials($this->invoice->restorant_id);

            if( empty($credentials) ){
                \Log::debug("GET INVOICE STATUS JOBS  >>>>>>>>>>>>>> No se tiene credenciales configuradas para emitir Facturas");
                $this->invoice->update([
                    'errores' => [ 
                        [
                            'code' => 0,
                            'descripcion' => 'Validación: No se tiene credenciales configuradas para emitir Facturas'
                        ]
                    ]
                ]);
                $this->fail();
            }

            if( empty($this->invoice->cuf) ){
                \Log::debug("GET INVOICE STATUS JOBS  >>>>>>>>>>>>>> La Factura No tiene CUF");
                $this->invoice->update([
                    'errores' => [ 
                        [
                        'code' => 0,
                        'descripcion' => 'Validación: La Factura No tiene CUF'
                        ]
                    ]
                ]);
                $this->fail();
            }

            $invoice_service = new FelInvoiceService($credentials->host);

            \Log::debug("Set Access Token Jobs >>>>>>>>>>>>>>>");
            
            $invoice_service->setAccessToken($credentials->access_token);
            
            \Log::debug("Set Cuf Jobs >>>>>>>>>>>>>>>");
            $invoice_service->setCuf($this->invoice->cuf);

            $response = $invoice_service->getInvoiceStatus();

            \Log::debug("GET INVOICE STATUS JOBS  >>>>>>>>>>>>> Statuts Response ");
            \Log::debug($response['status']);

            if($response['status'] == 'error'){
                \Log::debug("GET INVOICE STATUS JOBS >>>>>>>>>>>>>> Data Error");
                $this->invoice->update([
                    'errores' => [ 
                        [
                            'code' => 0,
                            'descripcion' => $response['errors']
                        ]
                    ]
                ]);
                $this->fail();
            }

            if( is_null ($response['data']['codigoEstado']) || !in_array($response['data']['codigoEstado'], StatusCodeInvoice::getFinalStatusArray($this->action) ) ){
                \Log::debug('GET INVOICE STATUS JOBS >>>>> La Factura aún esta Pendiente');

                // $this->release(60);
                throw new PosInvoicingException('Factura Pendiente');
            }

            $fel_invoice_repo->parseStatusResponse($response['data']);

            $fel_invoice_repo->update($this->invoice);


        } catch( PosInvoicingException | Exception $ex ){
            \Log::debug("GET INVOICE STATUS JOBS >>>>>>>>>>>>>>>>>>>>> Log Exception " .$ex->getMessage());

            $attemps_after = $this->delay_times[$this->attempts() - 1];

            if( $this->invoice->tipoEmision == EmissionTypes::FUERA_LINEA ){
                $attemps_after = $this->delay_offline[$this->attempts() - 1];
            }

            \Log::debug("Invoice #" . $this->invoice->numeroFactura ." Attempt after of ". $attemps_after . " Seconds");
            $this->release($attemps_after);
        }
    }


    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
        \Log::debug("Ocurrio un Error en realizar la Peticion de Estado Excepción: " . $exception->getMessage());

        Notification::route('mail', 'remberto.molina@ipxserver.com')->notify( new GetStatusInvoiceFailed($this->invoice, $exception->getFile() , $exception->getLine(), $exception->getMessage()) );

    }
}
