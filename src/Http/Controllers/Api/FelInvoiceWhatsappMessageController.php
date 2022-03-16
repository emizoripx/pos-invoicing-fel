<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers\Api;

use EmizorIpx\PosInvoicingFel\Http\Resources\ParametricResource;
use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Repository\ParametricRepository;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class FelInvoiceWhatsappMessageController extends Controller
{

    public function send( Request $request, $invoice_id ){
        
        try{

            \Log::debug("Send Whatsapp Message >>>>>>>>>>>>>>>>> ");

            \Log::debug("Reuqest ");
            
            $phone_number = request('phone_number');
            
            \Log::debug("Send Whatsapp Message >>>>>>>>>>>>>>>>> " . $phone_number);
            
            $invoice = FelInvoice::where('id', $invoice_id)->first();
            \Log::debug("Send Whatsapp Message >>>>>>>>>>>>>>>>> ");

            if( !isset($phone_number) || is_null($phone_number) ){
                $phone_number = $invoice->telefonoCliente;
            }
    
            if(is_null($invoice)){
                throw new Exception('No se la Factura');
            }

            if(is_null($phone_number) || empty($phone_number)){
                throw new Exception('No se encontro un número de telefono');
            }

            $fel_restorant = auth()->user()->restorant->fel_restorant;
            
            if( !isset($fel_restorant) || (isset($fel_restorant) && !$fel_restorant->enabled_whatsapp_send )){
                throw new Exception('No tiene habilitado el envío mensajes por Whatsapp');
            }

            $response = $invoice->whatsapp_service()->sendMessage($phone_number);
    
            return response()->json([
                'status' => true,
                'message'=> $response
            ]);
        } catch( Exception $ex ){
            \Log::debug("Error Al enviar Mensaje >>>>>>>>> " . $ex->getMessage());

            return response()->json([
                'status' => false,
                'message'=> $ex->getMessage()
            ]);
        }

    }

}
