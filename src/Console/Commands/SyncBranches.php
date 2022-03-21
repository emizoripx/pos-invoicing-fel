<?php

namespace EmizorIpx\PosInvoicingFel\Console\Commands;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelBranch;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Repository\FelBranchRepository;
use EmizorIpx\PosInvoicingFel\Repository\ParametricRepository;
use EmizorIpx\PosInvoicingFel\Services\Parametrics\ParametricsService;
use Exception;
use Illuminate\Console\Command;

class SyncBranches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emizor:sync-branch {restorant_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Branches of Company from FEL';

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
    public function handle( FelBranchRepository $fel_branch_repo )
    {
        try{

            $restorant_id = $this->argument('restorant_id');

            $credentials = FelToken::where('restorant_id', $restorant_id)->first();

            if( empty($credentials) ){
                $this->error('No se encontro credenciales configurados');
            }

            $parametric_service = new ParametricsService( $credentials->host );

            $parametric_service->setAccessToken($credentials->access_token);

            $response = $parametric_service->getBranches();

            $data = collect($response)->map( function ( $item ) use ($restorant_id) {
                
                $item = collect($item)->merge([ 'restorant_id' => intval($restorant_id),  'codigo_sucursal' => intval($item['codigoSucursal']), 'descripcion' => intval($item['codigoSucursal']) == 0 ? 'Casa Matriz' : 'Sucursal Nº '.$item['codigoSucursal'] ])->all();

                return collect( $item )->except(['municipio', 'pais', 'ciudad', 'telefono', 'codigoSucursal'])->all();
            })->all();

            \Log::debug("Data Parsed >>>>>>>>>>>>>>>> " . json_encode($data));

            $fel_branch_repo->upsert($data);

            $this->info('Sincronización de Productos SIN Finalida con Éxito');

        } catch(PosInvoicingException | Exception $ex){
            \Log::debug("Error al Sincronizar Sucursales " . $ex->getMessage() . " Linea : " . $ex->getLine());
            $this->error($ex->getMessage());
        }
    }
}
