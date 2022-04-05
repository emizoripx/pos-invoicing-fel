<?php

namespace EmizorIpx\PosInvoicingFel\Repository;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Services\Credentials\CredentialsService;
use Exception;

class FelTokenRepository {


    public function getCredentials($restorant_id){

        $fel_token = FelToken::where('restorant_id', $restorant_id)->select('access_token', 'host')->first();

        \Log::debug($fel_token);

        return $fel_token;

    }

    public function authenticateClient( $data ){
        try {

            \Log::debug("Request >>>>>>> " . json_encode($data));

            $credential_service = new CredentialsService($data['host']);

            $credential_service->setClientId( $data['client_id'] );
            $credential_service->setClientSecret($data['client_secret']);
            $credential_service->prepareData();

            $response = $credential_service->authenticate();

            return $response;


        } catch(PosInvoicingException $pex){

            \Log::debug("Error al guardar las credenciales " . $pex->getMessage());
            throw new Exception($pex->getMessage());
            
        }
    }


    public function save( $data, $response ){

        $fel_token = new FelToken();
        $fel_token->client_id = $data['client_id'];
        $fel_token->client_secret = $data['client_secret'];
        $fel_token->host = $data['host'];
        $fel_token->restorant_id = $data['restorant_id'];
        $fel_token->grant_type = "client_credentials";
        $fel_token->access_token = $response['access_token'];
        $fel_token->token_type = $response['token_type'];
        $fel_token->expires_in = $response['expires_in'];
        $fel_token->save();


    }

    public function update ( $model, $data, $response ){

        $model->client_id = $data['client_id'];
        $model->client_secret = $data['client_secret'];
        $model->host = $data['host'];
        $model->restorant_id = $data['restorant_id'];
        $model->grant_type = "client_credentials";
        $model->access_token = $response['access_token'];
        $model->token_type = $response['token_type'];
        $model->expires_in = $response['expires_in'];
        $model->save();

    }

}