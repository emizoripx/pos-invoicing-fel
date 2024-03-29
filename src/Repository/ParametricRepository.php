<?php

namespace EmizorIpx\PosInvoicingFel\Repository;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Services\Credentials\CredentialsService;
use EmizorIpx\PosInvoicingFel\Services\Parametrics\ParametricsService;
use EmizorIpx\PosInvoicingFel\Utils\Parametrics;
use Carbon\Carbon;
use stdClass;

class ParametricRepository {

    public function get($type){

        $parametrics = \DB::table(Parametrics::getTableName($type))->where('is_active', true)->get();

        return $parametrics;

    }
    public function getPluck($type, $restorant_id = null){

        if($type == Parametrics::SIN_PRODUCTS){
            
            $parametrics = \DB::table(Parametrics::getTableName($type))->where('restorant_id', $restorant_id)->pluck('descripcion', 'codigo')->all();

        } else {

            $parametrics = \DB::table(Parametrics::getTableName($type))->where('is_active', true)->pluck('descripcion', 'codigo')->all();
            
        }

        return $parametrics;

    }

    public function getUpdatedAt( $parametric, $restorant_id = null ){

        if($parametric == Parametrics::SIN_PRODUCTS){
            
            $updated_at = \DB::table(Parametrics::getTableName($parametric))->where('restorant_id', $restorant_id )->orderBy('updated_at', 'desc')->pluck('updated_at')->first();

        } else{

            $updated_at = \DB::table(Parametrics::getTableName($parametric))->orderBy('updated_at', 'desc')->pluck('updated_at')->first();
        }


        \Log::debug("Get updated_at: ". $updated_at);
        \Log::debug("Get updated_at: ". strtotime($updated_at));

        return strtotime(is_null($updated_at) ? 0 : $updated_at);

    }

    public function saveParametrics($type, $data, $restorant_id = null){

        // $local_parametrics = \DB::table(Parametrics::getTableName($type))->get();

        $response_parametrics = collect($data);

        $data_prepared = $response_parametrics->map( function ($item) {

                return collect($item)->except(['isActive'])->all();

            })->all();
        
        $model = Parametrics::getNameClass($type);

        \Log::debug("Prepared Data >>>>>>>>>>>> ". json_encode($data_prepared));
        \Log::debug($model);

        if($type == Parametrics::SIN_PRODUCTS){
            \Log::debug("Update SIN PRODUCTS >>>>>>>>>>>>>> ");
            $data_concatenated = collect($data_prepared)->map( function ($item) use ($restorant_id) {

                return collect($item)->merge(['restorant_id' => $restorant_id])->all();

            })->all();
            \Log::debug("Products contateneted >>>>>>>>>>>>>> " . json_encode($data_concatenated) );
            $model::upsert($data_concatenated, ['codigo', 'codigoActividad', 'restorant_id'], ['descripcion']);
        } else {

            $model::upsert($data_prepared, ['codigo'], ['descripcion']);
        }



    }

    public function syncParametrics() {

        $credentials = FelToken::where('host', config('posinvoicingfel.api_url'))->first();

        if( empty($credentials) ){

            $credential_service = new CredentialsService(config('posinvoicingfel.api_url'));

            $credential_service->setClientId(config('posinvoicingfel.client_id_demo'));
            $credential_service->setClientSecret(config('posinvoicingfel.client_secret_demo'));

            $credential_service->prepareData();

            $response_token = $credential_service->authenticate();

            $new = new stdClass();

            $new->host = config('posinvoicingfel.api_url') ;
            $new->access_token = $response_token['access_token'];

            $credentials = $new;

        }

        $parametric_service = new ParametricsService( $credentials->host );

        $parametric_service->setAccessToken($credentials->access_token);

        $types = Parametrics::getAll();

        foreach ($types as $type) {
            $updated_at = $this->getUpdatedAt($type);

            $parametric_service->setTypeParametric( Parametrics::getTypeUri($type) );

            $response = $parametric_service->get( $updated_at );

            $this->saveParametrics($type, $response);
        }


    }

    public function syncSinProducts( $restorant_id ) {

        $credentials = FelToken::where('restorant_id', $restorant_id)->first();

        if( empty($credentials) ){
            throw new PosInvoicingException('Credenciales no configurados para la compañía');
        }

        $parametric_service = new ParametricsService( $credentials->host );

        $parametric_service->setAccessToken($credentials->access_token);


        $updated_at = $this->getUpdatedAt(Parametrics::SIN_PRODUCTS, $restorant_id);

        $parametric_service->setTypeParametric( Parametrics::getTypeUri(Parametrics::SIN_PRODUCTS) );

        $response = $parametric_service->get( $updated_at );

        $this->saveParametrics(Parametrics::SIN_PRODUCTS, $response, $restorant_id);

        \DB::table('fel_restorants')->where('restorant_id', $restorant_id)->update([ 'last_products_sync' => Carbon::now()->toDateTimeString() ]);


    }

    
}