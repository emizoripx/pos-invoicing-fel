<?php

namespace EmizorIpx\PosInvoicingFel\Console\Commands;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Repository\FelBranchRepository;
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
    protected $description = 'Sync branches from FEL';

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

            if( ! $credentials ) {
                $this->error('No se encontró credenciales configurados');
            }

            \Log::debug('Credentiales: ' . json_encode( $credentials ));
            $parametric_service = new ParametricsService( $credentials->host);

            $parametric_service->setAccessToken( $credentials->access_token );

            $response = $parametric_service->getBranches();

            $data = collect( $response )->map( function ($item) use ( $restorant_id ) {

                $item = collect( $item )->merge([
                    'restorant_id' => intval( $restorant_id ),
                    'codigo_sucursal' => $item['codigoSucursal'],
                    'descripcion' => $item['codigoSucursal'] == '0' ? 'Casa Matriz' : 'Sucursal Nº' . $item['codigoSucursal']
                ])->all();

                return collect( $item )->except(['municipio', 'pais', 'ciudad', 'telefono', 'codigoSucursal'])->all();
            })->all();

            \Log::debug('Data Prepared: ' . json_encode($data));

            $fel_branch_repo->upsert($data);

            $this->info('Sincronización de Sucursales Finalizada con éxito');

        } catch(PosInvoicingException | Exception $ex) {

            \Log::debug('Error al sincronizar Sucursales: ' . $ex->getMessage() . ' File: ' . $ex->getFile() . ' Line: ' . $ex->getLine());

            $this->error($ex->getMessage());
        }
    }
}
