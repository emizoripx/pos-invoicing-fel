<?php

namespace EmizorIpx\PosInvoicingFel\Console\Commands;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Repository\ParametricRepository;
use Exception;
use Illuminate\Console\Command;

class SyncParametrics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emizor:sync-parametric';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync parametrics of FEL';

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

            $parametric_repo = new ParametricRepository();

            $parametric_repo->syncParametrics();

            $this->info('Sincronización Finalida con Éxito');

        } catch(PosInvoicingException | Exception $ex){
            $this->error($ex->getMessage());
        }
    }
}
