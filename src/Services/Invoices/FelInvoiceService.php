<?php

namespace EmizorIpx\PosInvoicingFel\Services\Invoices;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Services\BaseConnection;
use EmizorIpx\PosInvoicingFel\Services\Invoices\Resources\CompraVentaResource;
use Exception;
use Throwable;

class FelInvoiceService extends BaseConnection {

    protected $access_token ;

    protected $data;

    protected $prepared_data;

    protected $data_model;

    protected $response;

    protected $branch_number = 0;

    protected $type_document = 'compra-venta';

    protected $cuf ;

    public function __construct($host)
    {
        parent::__construct($host);
    }

    public function setAccessToken($access_token)
    {
        \Log::debug("SET ACCESS TOEKN >>>>>>>>>>>>>>>>>");
        $this->access_token = $access_token;
    }


    public function setData($data)
    {
        $this->data  = $data;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function setDataModel($data)
    {
        $this->data_model  = $data;
    }

    public function setCuf($cuf){
        \Log::debug("SET CUF >>>>>>>>>>>>>>>>>>>>>>>>> ");
        $this->cuf = $cuf;
    }

    public function checkPatameters(){
        if (empty($this->access_token)) {
            throw new PosInvoicingException("El access token es necesario");
        }

        if ($this->branch_number < 0) {
            throw new PosInvoicingException("El branch_number es necesario");
        }

        if (empty($this->data)) {
            throw new PosInvoicingException ("Los datos son necesarios para enviar.");
        }
    }

    public function validateData()
    {

        $rules = [
            "numeroFactura"=> 'required|integer',
            "nombreRazonSocial"=> "required",
            "codigoTipoDocumentoIdentidad"=> "required|integer",
            "numeroDocumento"=> "required",
            "complemento"=> "nullable|string",
            "codigoCliente"=> "required",
            // "codigoMetodoPago"=> "required|integer",
            "numeroTarjeta"=> "nullable|integer",
            "montoTotal"=> "required|numeric",
            "usuario"=> "required|string",
            "emailCliente"=> "nullable|string",
            "telefonoCliente"=> "nullable|string",
            "montoTotalSujetoIva"=> "required|numeric",
            "detalles.*.codigoProducto"=> "nullable|string",
            "detalles.*.descripcion"=> "required|string",
            "detalles.*.unidadMedida"=> "required|integer",
            "detalles.*.precioUnitario"=> "required|numeric",
            "detalles.*.subTotal"=> "required|numeric",
            "detalles.*.cantidad"=> "required|numeric",
            "detalles.*.montoDescuento"=> "nullable|numeric",
        ];
        $messages = [
            "numeroFactura.required"=> 'El número de factura  es necesario.',
            "numeroFactura.integer"=> 'El número de factura  deber ser entero.',
            "nombreRazonSocial.required"=> "La razón social del cliente es necesaria",
            "codigoTipoDocumentoIdentidad.required"=> "El código del tipo de documento es necesario",
            "codigoTipoDocumentoIdentidad.integer"=> "El código del tipo de documento debe ser entero",
            "numeroDocumento.required"=> "El número de documento es necesario",
            "codigoCliente.required"=> "El código del cliente es necesario",
            // "codigoMetodoPago.required"=> "El código del método de pago es necesario",
            // "codigoMetodoPago.integer"=> "El código del método del pago debe ser entero",
            "montoTotal.required"=> "El monto total es necesario.",
            "montoTotal.numeric"=> "El monto total debe ser numérico",
            "usuario.required"=> "El nombre del usuario es requerido",
            "emailCliente.email"=> "El email del cliente no es válido",
            "montoTotalSujetoIva.required"=> "El monto total sujeto a iva es necesario",
            "montoTotalSujetoIva.numeric"=> "El monto total sujeto a iva debe ser numérico",
            "detalles.*.codigoProducto.required"=> "El código del producto es necesario",
            "detalles.*.descripcion.required"=> "La descripción del producto es necesaria",
            "detalles.*.unidadMedida.required"=> "La unidad de medida del producto es necesaria",
            "detalles.*.unidadMedida.integer"=> "La unidad de medida del produto debe ser entero",
            "detalles.*.precioUnitario.required"=> "El precio unitario del producto es necesario",
            "detalles.*.precioUnitario.numeric"=> "El precio unitario del producto debe ser numérico",
            "detalles.*.subTotal.required"=> "El subtotal del producto es necesario",
            "detalles.*.subTotal.numeric"=> "El subtotal del producto debe ser numérico",
            "detalles.*.cantidad.required"=> "La cantidad del producto es necesaria",
            "detalles.*.cantidad.numeric"=> "La cantidad del producto debe ser numérica",
            "detalles.*.montoDescuento.numeric"=> "El monto de descuento debe ser numérico"
        ];
    
        $response = validator($this->data, $rules, $messages);
        
        if (sizeof($response->errors()) > 0 ){
            
            throw new PosInvoicingException(json_encode($response->errors())) ;
        }


    }

    public function buildData(FelInvoice $model) {

        try{

            $this->setData($model->toArray());
            $this->setDataModel($model);

        } catch(Exception $ex) {
            
            \Log::error($ex->getMessage());

            throw new PosInvoicingException("Ocurrio un problema al construir los datos para enviar a FEL");
        }
        
    }

    public function prepareData()
    {
        
        try{
            $this->prepared_data =  new CompraVentaResource ($this->data_model);
            \Log::debug("Data");
            \Log::debug(json_encode($this->prepared_data));
        }catch(Throwable $th) {
            \Log::error($th);
        }
    }


    public function sendToFel(){

        $this->checkPatameters();

        $this->validateData();

        $this->prepareData();

        try{

            \Log::debug("Send to : " . "/api/v1/sucursales/0/facturas/compra-venta" );
            \Log::debug("data : " . json_encode($this->prepared_data));

            $response = $this->client->request('POST', "/api/v1/sucursales/$this->branch_number/facturas/$this->type_document", ["json" => $this->prepared_data, "headers" => ["Authorization" => "Bearer " . $this->access_token]]);
            $parsed_response = $this->parse_response($response);
            $this->setResponse($parsed_response);
            
            return $parsed_response;


        } catch(Exception $ex){

            \Log::error($ex->getMessage());

            throw new PosInvoicingException("Error en la creación de la factura: " . $ex->getMessage() );

        }

    }

    public function getInvoiceStatus(){

        \Log::debug("GET to : " . "/api/v1/facturas/$this->cuf/status" );

        try{

            $response = $this->client->request('GET', "/api/v1/facturas/$this->cuf/status", ["headers" => ["Authorization" => "Bearer " . $this->access_token]]);
            
            $r = json_decode( (string) $response->getBody(), true);
            \Log::debug("............................................");
            \Log::debug($r['data']);
            return json_decode( (string) $response->getBody(), true);

        } catch(Exception $ex){

            \Log::error($ex->getMessage());

            throw new PosInvoicingException("Error al Obtener el Estado de la factura: " . $ex->getMessage() );
        }


    }
    
}