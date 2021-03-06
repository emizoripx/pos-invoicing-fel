<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers\Api;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Jobs\GetInvoiceStatus;
use EmizorIpx\PosInvoicingFel\Jobs\SendWhatsappMessage;
use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceRepository;
use EmizorIpx\PosInvoicingFel\Repository\FelTokenRepository;
use EmizorIpx\PosInvoicingFel\Services\DynamicLink\DynamicLinkService;
use EmizorIpx\PosInvoicingFel\Services\Invoices\FelInvoiceService;
use EmizorIpx\PosInvoicingFel\Services\Nit\NitService;
use EmizorIpx\PosInvoicingFel\Utils\ActionTypes;
use EmizorIpx\PosInvoicingFel\Utils\StatusCodeInvoice;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class FelInvoiceController extends Controller
{
    protected $felinvoice_repo;

    protected $feltoken_repo;

    protected $dynamic_link_service;

    protected $nit_service;

    public function __construct( FelInvoiceRepository $felinvoice_repo, FelTokenRepository $feltoken_repo, DynamicLinkService $dynamic_link_service, NitService $nit_service )
    {
        $this->felinvoice_repo = $felinvoice_repo;    
        $this->feltoken_repo = $feltoken_repo;
        $this->dynamic_link_service = $dynamic_link_service;
        $this->nit_service = $nit_service;
    }

    public function emit( Request $request, $order_id ){
        try{
            $init = microtime(true);

            if(!auth()->user()){
                throw new Exception('La Sesión caducó, Por vuelva a iniciar sesión');
            }

            \Log::debug("Emitir Factura >>>>>>>>>>>>>>>>>> ");

            $fel_invoice = FelInvoice::where('order_id', $order_id)->first();

            if( empty($fel_invoice) ){
                throw new Exception('No se encontro una orden asociada para crear la Factura');
            }

            if( $fel_invoice->cuf != null ){
                throw new Exception('La orden #'. $fel_invoice->order_id .' ya fue Facturada');
            }

            
            
            \Log::debug("Buscar Token >>>>>>>>>>>>>>>>>> ");
            $fel_token = FelToken::where('restorant_id', $fel_invoice->restorant_id)->first();
            
            if( empty($fel_token) ){
                throw new Exception('No se tiene credenciales configuradas para emitir Facturas');
            }

            $next_number = $fel_invoice->fel_restorant->service()->getNextNumber();
            \Log::debug("NextNumberInvoice  >>>>>>>>>>>>>>>>>> " . $next_number);

            $fel_invoice->numeroFactura = $next_number;
            $fel_invoice->save();

            $invoice_service = new FelInvoiceService( $fel_token->host );

            \Log::debug("Set Token >>>>>>>>>>>>>>>>>> ");
            $invoice_service->setAccessToken($fel_token->access_token);

            \Log::debug("Set Data >>>>>>>>>>>>>>>>>> ");
            $initBuild = microtime(true);
            $invoice_service->buildData($fel_invoice);
            \Log::debug("TIME OF BUILD DATA >>>>>>>>>>>>>>>>>> " . (microtime(true) - $initBuild) );

            \Log::debug("Enviar a FEL >>>>>>>>>>>>>>>>>> ");
            $initSendFel = microtime(true);
            $invoice_service->sendToFel();
            \Log::debug("TIME OF SEND FEL >>>>>>>>>>>>>>>>>> " . (microtime(true) - $initSendFel) );

            \Log::debug("Parse Response >>>>>>>>>>>>>>>>>> ");
            $initParseData = microtime(true);
            $this->felinvoice_repo->parseResponseToSave($invoice_service->getResponse());
            \Log::debug("TIME OF PARSE DATA >>>>>>>>>>>>>>>>>> " . (microtime(true) - $initParseData));

            \Log::debug("Actualizar Factura >>>>>>>>>>>>>>>>>> ");
            $initUpdate = microtime(true);
            $fel_invoice = $this->felinvoice_repo->update($fel_invoice);
            \Log::debug("TIME OF UPDATE DATA >>>>>>>>>>>>>>>>>> " . (microtime(true) - $initUpdate) );

            GetInvoiceStatus::dispatch($fel_invoice, ActionTypes::EMIT)->delay( now()->addSeconds(5) );

            $fel_restorant = auth()->user()->restorant->fel_restorant;
            if( isset($fel_restorant) && $fel_restorant->enabled_whatsapp_send && $fel_restorant->enabled_whatsapp_auto_send && !is_null($fel_invoice->telefonoCliente)){

                SendWhatsappMessage::dispatch($fel_invoice)->delay(now()->addSeconds(2));
            }

            $initDynamic = microtime(true);
            $short_url = $this->dynamic_link_service->generateDynamicLink($fel_invoice->url_pdf);
            $fel_invoice->short_pdf_url = $short_url;
            $fel_invoice->save();
            \Log::debug("TIME OF DYNAMIC LINK >>>>>>>>>>>>>>>>>> " . (microtime(true) - $initDynamic) );

            $fel_invoice->fechaEmision = $fel_invoice->formatted_fecha_emision;

            \Log::debug("TIME OF STORAGE >>>>>>>>>>>>>>>>>> " . (microtime(true) - $init) );
            return response()->json([
                'status' => true,
                'message' => 'Factura Enviada',
                'invoice'=>$fel_invoice
            ]);

        
        } catch(PosInvoicingException | Exception $ex){
            \Log::debug("Error en la Emisión: " . $ex->getMessage() . "File: " . $ex->getFile() . " Line: ". $ex->getLine());
            
            if($fel_invoice->cuf == null ){
                $previus_number = $fel_invoice->fel_restorant->service()->getPreviousNumber();
                \Log::debug("Reduce last number applied " . $previus_number);
            }
            
            return response()->json([
                'status' => false,
                'message'=> $ex->getMessage()
            ]);
        }


    }

    public function show( Request $request, $order_id ){

        try{

            $invoice = $this->felinvoice_repo->get($order_id);

            if( !auth()->user() || auth()->user()->restaurant_id != $invoice->restorant_id){
                throw new Exception(__('No Access.'));
            }

            $invoice->fechaEmision = $invoice->formatted_fecha_emision;

            return response()->json([
                'status' => true,
                'invoice'=> is_null($invoice) ? null : $invoice
            ]);

        } catch(Exception $ex){
            return response()->json([
                'status' => false,
                'message'=> $ex->getMessage()
            ]);
        }
        


    }

    public function revocate( Request $request, $order_id ){

        try{
            \Log::debug("Revocate Invoice >>>>>>>>>>>>>>>>>>>> Init");
            $invoice = $this->felinvoice_repo->get($order_id);

            if(is_null($invoice)){
                throw new PosInvoicingException('No se encontro la factura');
            }
            
            if( !auth()->user() || auth()->user()->restaurant_id != $invoice->restorant_id){
                throw new Exception(__('No Access.'));
            }

            if(is_null($invoice->cuf)){
                throw new PosInvoicingException('La factura no fue emitida');
            }
            if($invoice->codigoEstado == 691){
                throw new PosInvoicingException('La Factura ya fue anulada');
            }
            if($invoice->codigoEstado != 690){
                throw new PosInvoicingException('Sólo se puede anular un factura válida');
            }

            $codigoMotivoAnulacion = request('codigo_motivo_anulacion');
            if(!isset($codigoMotivoAnulacion)){
                throw new PosInvoicingException ("Código Motivo de Anulación es requerido");
            }

            $credentials = $this->feltoken_repo->getCredentials($invoice->restorant_id);

            if( empty($credentials) ){
                throw new PosInvoicingException ("No se tiene credenciales configuradas para anular Facturas");
            }

            $invoice_service = new FelInvoiceService($credentials->host);

            $invoice_service->setAccessToken($credentials->access_token);

            $invoice_service->setCuf($invoice->cuf);

            $invoice_service->setRevocationReasonCode($codigoMotivoAnulacion);

            $invoice_service->revocate();

            GetInvoiceStatus::dispatch($invoice, ActionTypes::REVOCATE)->delay( now()->addSeconds(4) );

            return response()->json([
                'status' => true,
                'message' => 'Factura Anulada',
                'invoice'=>$invoice
            ]);


        } catch(PosInvoicingException | Exception $ex){
            return response()->json([
                'status' => false,
                'message'=> $ex->getMessage()
            ]);
        }

    }

    public function validateState( Request $request, $invoice_id ){

        try {

            $invoice = $this->felinvoice_repo->getInvoice($invoice_id);
    
            if(is_null($invoice)){
                throw new PosInvoicingException('No se encontro la factura');
            }

            if(is_null($invoice->cuf)){
                throw new PosInvoicingException('La factura no fue emitida');
            }

            $credentials = $this->feltoken_repo->getCredentials($invoice->restorant_id);

            if( empty($credentials) ){
                throw new PosInvoicingException ("No se tiene credenciales configuradas para anular Facturas");
            }

            $invoice_service = new FelInvoiceService($credentials->host);

            $invoice_service->setAccessToken($credentials->access_token);

            $invoice_service->setCuf($invoice->cuf);

            $response = $invoice_service->getInvoiceStatus();

            if($response['status'] == 'error'){
                \Log::debug("GET INVOICE STATUS JOBS >>>>>>>>>>>>>> Data Error " . $response['errors']);
                throw new PosInvoicingException($response['errors']);
            }

            if( is_null ($response['data']['codigoEstado']) || !in_array($response['data']['codigoEstado'], StatusCodeInvoice::getFinalStatusArray('') ) ){
                \Log::debug('GET INVOICE STATUS JOBS >>>>> La Factura aún esta Pendiente');

                throw new PosInvoicingException('Factura Pendiente');
            }

            $this->felinvoice_repo->parseStatusResponse($response['data']);

            $this->felinvoice_repo->update($invoice);


            return response()->json([
                'status' => true,
                'message' => 'Se Validó el Estado de la Factura',
                'invoice'=>$invoice
            ]);


        } catch( PosInvoicingException | Exception $ex ){

            return response()->json([
                'status' => false,
                'message'=> $ex->getMessage()
            ]);

        }

    }

    public function validateNIT( Request $request ) {

        \Log::debug("Validate NIT ENTER ");
        
        $nit = $request->get('nit');
        \Log::debug("Validate NIT Number: " . $nit);

        try {

            $response = $this->nit_service->validate($nit);
    
            return $response;
        } catch( Exception $ex ) {
            return [];
        }

    }
}
