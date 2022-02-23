<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
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
            $invoice_service->buildData($fel_invoice);

            \Log::debug("Enviar a FEL >>>>>>>>>>>>>>>>>> ");
            $invoice_service->sendToFel();

            \Log::debug("Parse Response >>>>>>>>>>>>>>>>>> ");
            $this->felinvoice_repo->parseResponseToSave($invoice_service->getResponse());

            \Log::debug("Actualizar Factura >>>>>>>>>>>>>>>>>> ");
            $fel_invoice = $this->felinvoice_repo->update($fel_invoice);

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
}
