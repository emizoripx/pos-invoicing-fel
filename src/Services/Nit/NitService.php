<?php

namespace EmizorIpx\PosInvoicingFel\Services\Nit;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class NitService {


    protected $client;

    protected $parsed_response;

    public function __construct()
    {
        \Log::debug("Data Cliente >>>>>>>>>>> " . 'Bearer ');
        $data_client['base_uri'] = 'https://pbdw.impuestos.gob.bo:8080';
        $data_client['verify'] = false;


        $this->client = new Client($data_client);

    }


    public function setResponse($value){
        $this->parsed_response = $value;
    }


    public function validate ( $nit ){
        \Log::debug("Validate NIT Service");
        try{

            $url = '/gob.sin.padron.servicio.web/consulta/verificarContribuyente?nit=' . $nit;

            \Log::debug("URL to GET: " . $url);
            $response = $this->client->request( 'GET', $url );

            \Log::debug("Response Send Message >>>>>>>>>>>>>> " . $response->getBody());

            return $response->getBody();
        
        } catch(RequestException $ex){

            \Log::debug("Error al enviar el mensaje ". $ex->getResponse()->getBody());

            throw new Exception( $ex->getResponse()->getBody(), true );

        }

    }

}
