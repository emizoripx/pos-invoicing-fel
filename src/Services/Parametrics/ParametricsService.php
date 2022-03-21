<?php 

namespace EmizorIpx\PosInvoicingFel\Services\Parametrics;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Services\BaseConnection;
use Exception;

class ParametricsService extends BaseConnection {

    protected $access_token;

    protected $response;

    protected $type_parametric;

    public function __construct($host)
    {
        parent::__construct($host);
    }

    public function setAccessToken( $value ){
        $this->access_token = $value;
    }

    public function setTypeParametric($value){
        $this->type_parametric = $value;
    }

    public function setResponse($value)
    {
        $this->response = $value;
    }

    public function get( $updated_at = '', $all = '' ){

        \Log::debug('/api/v1/parametricas/' . $this->type_parametric.'?updated_at=' .$updated_at. '&all=' .$all);

        try{

            $response = $this->client->request('GET', '/api/v1/parametricas/' . $this->type_parametric.'?updated_at=' .$updated_at. '&all=' .$all, ["headers" => ["Authorization" => "Bearer " . $this->access_token]]);

            $this->setResponse($this->parse_response($response));

            \Log::debug("Reponse Parametrics >>>>>>>> " . json_encode($this->response));

            return $this->response;

        } catch(Exception $ex){

            \Log::error($ex->getMessage());

            throw new PosInvoicingException($ex->getMessage());

        }


    }

    public function getBranches(){

        \Log::debug('/api/v1/sucursales');
        try{

            $response = $this->client->request('GET', '/api/v1/sucursales', ["headers" => ["Authorization" => "Bearer " . $this->access_token]] );

            $this->setResponse( $this->parse_response( $response ) );

            return $this->response;


        } catch(Exception $ex){
            \Log::error($ex->getMessage());

            throw new PosInvoicingException($ex->getMessage());
        }

    }

}