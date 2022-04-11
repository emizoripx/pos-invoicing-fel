<?php


namespace EmizorIpx\PosInvoicingFel\Services\DynamicLink;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DynamicLinkService {

    protected $path;

    protected $api_key;

    protected $header_data;

    protected $data;

    protected $client;


    public function __construct()
    {
        $this->path = "/v1/shortLinks";
        $this->api_key = env('FIREBASE_WEB_KEY');

        $data_header['base_uri'] = "https://firebasedynamiclinks.googleapis.com";
        $data_header['headers']['Content-Type'] = 'application/json';
        $this->client = new Client($data_header);

    }

    public function setHeaderData(){
        $this->header_data = [
            'Content-Type' => 'application/json'
        ];
    }

    public function setData($url){

        $this->data = [
            "dynamicLinkInfo" => [
                "domainUriPrefix" => "https://elink.emizor.com",
                "link" => $url
            ],
            "suffix" => [
                "option" => "SHORT"
            ]
        ];

    }

    public function generateDynamicLink($url){

        try{

            $shortLink = "";
            $this->setHeaderData();
            $this->setData($url);
    
            $response = $this->client->request('POST', "$this->path?key=$this->api_key", ["json" => $this->data, "headers" => $this->header_data, 'timeout' => 2]);

            $parsed_response = json_decode( (string) $response->getBody(), true);
            
            if(isset($parsed_response['shortLink'])){
                $shortLink = $parsed_response['shortLink'];
            } else {
                \Log::debug("No se encontro el shortLink en la respuesta");
            }

            return $shortLink;

        } catch(RequestException $ex){

            \Log::debug("Ocurrio un error al generar en link " . $ex->getResponse()->getBody());

            return "";

        } catch( Exception $exx ){
            \Log::debug("Ocurrio un error al generar en link " . $exx->getMessage());

            return "";
        }


    }

}