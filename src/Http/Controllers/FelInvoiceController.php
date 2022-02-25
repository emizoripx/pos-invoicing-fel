<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Jobs\GetInvoiceStatus;
use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceRepository;
use EmizorIpx\PosInvoicingFel\Services\Invoices\FelInvoiceService;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class FelInvoiceController extends Controller
{
    protected $felinvoice_repo;

    public function __construct( FelInvoiceRepository $felinvoice_repo )
    {
        $this->felinvoice_repo = $felinvoice_repo;    
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

            GetInvoiceStatus::dispatch($fel_invoice)->delay( now()->addSeconds(10) );

            \Log::debug("TIME OF STORAGE >>>>>>>>>>>>>>>>>> " . (microtime(true) - $init) );
            return response()->json([
                'status' => true,
                'message' => 'Factura Enviada',
                'invoice'=>$fel_invoice
            ]);

        
        } catch(PosInvoicingException | Exception $ex){
            \Log::debug("Error en la Emisión: " . $ex->getMessage());

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
}
