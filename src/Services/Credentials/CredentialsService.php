<?php

namespace EmizorIpx\PosInvoicingFel\Services\Credentials;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Services\BaseConnection;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class CredentialsService extends BaseConnection {

    protected $client_id;

    protected $client_secret;

    protected $data;

    public function __construct( $host )
    {
        parent::__construct($host);
    }

    public function setClientId($value){

        $this->client_id = $value;

    }

    public function setClientSecret($value){

        $this->client_secret = $value;

    }

    public function hasCredentials()
    {
        if (!$this->client_id ) 
            throw new PosInvoicingException("Es requerido el client_id");

        if (!$this->client_secret) 
            throw new PosInvoicingException("Es requerido el client_secret");

    }

    public function prepareData(){

        $this->hasCredentials();
        
        $this->data = [
            "grant_type" => "client_credentials",
            "client_id" => (int) $this->client_id,
            "client_secret" => $this->client_secret
        ];
    }


    public function authenticate(){

        try {

            \Log::debug("Data to sent >>>>>>>>>>>>>>>>");
            \Log::debug($this->data);
            $response = $this->client->request('POST', '/oauth/token', ['json' => $this->data]);
            
            
            return $this->parse_response($response);

        } catch( ClientException $cex ){

            $errors = json_decode($cex->getResponse()->getBody());
            \Log::error(__($errors->error));

            throw new PosInvoicingException( __($errors->error) );

        } catch( ConnectException $rex ){

            \Log::error($rex->getMessage());
            throw new PosInvoicingException( "No se pudo etablecer conexión con el Host" );

        } catch (\Exception $ex) {

            \Log::error('Error en la autenticación, Verificar Credenciales ' . $ex->getMessage());
            
            throw new PosInvoicingException($ex->getMessage());

        }

    }


    

}