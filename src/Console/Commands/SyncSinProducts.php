<?php

namespace EmizorIpx\PosInvoicingFel\Console\Commands;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Repository\ParametricRepository;
use Exception;
use Illuminate\Console\Command;

class SyncSinProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emizor:sync-products {restorant_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync SIN products of FEL';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle( )
    {
        try{

            $restorant_id = $this->argument('restorant_id');

            $parametric_repo = new ParametricRepository();

            $parametric_repo->syncSinProducts($restorant_id);

            $this->info('Sincronización de Productos SIN Finalida con Éxito');

        } catch(PosInvoicingException | Exception $ex){
            \Log::debug("Error al Sincronizar Productos SIN " . $ex->getMessage() . " Linea : " . $ex->getLine());
            $this->error($ex->getMessage());
        }
    }
}
