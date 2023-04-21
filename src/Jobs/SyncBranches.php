<?php

namespace EmizorIpx\PosInvoicingFel\Jobs;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Repository\FelBranchRepository;
use EmizorIpx\PosInvoicingFel\Services\Parametrics\ParametricsService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class SyncBranches implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $restorant_id;

    public $tries = 2;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $restorant_id )
    {
        $this->restorant_id = $restorant_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle( FelBranchRepository $fel_branch_repo )
    {
        try{

            $credentials = FelToken::where('restorant_id', $this->restorant_id)->first();

            if( ! $credentials ) {
                \Log::debug('No se encontr√≥ credenciales configurados');
            }

            \Log::debug('Credentiales: ' . json_encode( $credentials ));
            $parametric_service = new ParametricsService( $credentials->host);

            $parametric_service->setAccessToken( $credentials->access_token );

            $response = $parametric_service->getBranches();

            $data = collect( $response )->map( function ($item){

                $item = collect( $item )->merge([
                    'restorant_id' => intval( $this->restorant_id ),
                    'codigo_sucursal' => $item['codigoSucursal'],
                    'descripcion' => $item['codigoSucursal'] == '0' ? 'Casa Matriz' : 'Sucursal Nº' . $item['codigoSucursal']
                ])->all();

                return collect( $item )->except(['municipio', 'pais', 'ciudad', 'telefono', 'codigoSucursal'])->all();
            })->all();

            \Log::debug('Data Prepared: ' . json_encode($data));

            $fel_branch_repo->upsert($data);

            \Log::debug('Sincronización de Sucursales Finalizada con éxito');

        } catch(PosInvoicingException | Exception $ex) {

            \Log::debug('Error al sincronizar Sucursales: ' . $ex->getMessage() . ' File: ' . $ex->getFile() . ' Line: ' . $ex->getLine());

        }

    }
}
