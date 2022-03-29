<?php

namespace EmizorIpx\PosInvoicingFel\Jobs;

use App\Restorant;
use EmizorIpx\PosInvoicingFel\Imports\FelInvoiceAuxImport;
use EmizorIpx\PosInvoicingFel\Models\FelContingencyFile;
use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceAuxRepository;
use EmizorIpx\PosInvoicingFel\Utils\ContingencyFileStatus;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Throwable;

use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;

class ProcessInvoicesContingecy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file ;

    protected $restorant;

    protected $user_id;

    protected $invoice_aux_repo;


    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( FelContingencyFile $file, $user_id)
    {
        $this->file = $file;
        $this->restorant = auth()->user()->restorant;
        $this->user_id = $user_id;

        $this->invoice_aux_repo = new FelInvoiceAuxRepository();
    }


    public function middleware(){

        return [ (new WithoutOverlapping($this->file->id))->releaseAfter(10)]; //Re-intertar luego de 10 seg.

    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{


            \Log::debug("PROCESS INVOICES JOBS INIT >>>>>>>>>>>>>>>>>>>>> #". $this->file->file_name . " Attempts #". $this->attempts());
            
            
            $init = microtime(true);

            $cafc_code = $this->file->cafc_code;
            $this->file->update(['state' => ContingencyFileStatus::STATUS_PROCESSING]);
            Excel::import( new FelInvoiceAuxImport($this->restorant, $this->user_id, $this->file->id, $cafc_code->from_invoice_number, $cafc_code->to_invoice_number, $cafc_code->cafc), $this->file->file_path, 's3', \Maatwebsite\Excel\Excel::CSV );
            

            $this->invoice_aux_repo->setCafcCode( $cafc_code->cafc );

            $error_invoices = $this->invoice_aux_repo->processInvoices($this->file->id);

            if( count($error_invoices) == 0){
                $this->file->update(['state' => ContingencyFileStatus::STATUS_PROCESSED, 'processed_at' => Carbon::now()]);
                
            } else {
                $this->file->update(['state' => ContingencyFileStatus::STATUS_OBSERVED]);
                $this->file->errors = [ 'error' => 'Error al Procesar Facturas' ];
                $this->file->save();

                \Log::debug("Invoices Fails " . json_encode($error_invoices));

                $this->invoice_aux_repo->makeErrorsReport($this->file->id, $error_invoices, $this->file->file_name, $this->restorant->id);
            }

        \Log::debug("TIME OF JOBS FINAL >>>>>>>>>>>>>>>>>> " . (microtime(true) - $init) );


        } catch( Exception $ex ){
            \Log::debug("CONTINGENCY JOBS >>>>>>>>>>>>>>>>>>>>> Log Exception " .$ex->getMessage() . " FILE " .$ex->getFile() . ' Line ' . $ex->getLine());

            $this->file->update(['state' => ContingencyFileStatus::STATUS_OBSERVED]);
            $this->file->errors = [ 'error' => $ex->getMessage() ];
            $this->file->save();

            $this->invoice_aux_repo->removeRegisters($this->file->id, $this->restorant->id);

            $this->fail($ex);

        }
    }


    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
        \Log::debug("Ocurrio un Error en realizar la Peticion de Estado Excepción: " . $exception->getMessage());
    }
}
