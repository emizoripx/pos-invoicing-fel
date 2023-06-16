<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers;

use EmizorIpx\PosInvoicingFel\Models\FelRestorant;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class FelRestorantController extends Controller {

    public function updateSettings (Request $request, $restorant_id) {

        try {

            $fel_restorant = FelRestorant::where('id', $restorant_id)->first();
    
            $settings = [];
    
    
            if( isset($request->font_size)){
                $settings['font_size'] = empty($request->font_size) ? '12' : $request->font_size;
            }
            if( isset($request->product_delivery_code)){
                $settings['product_delivery_code'] =  $request->product_delivery_code;
            }
            if( isset($request->enable_invoices_staff)){
                $settings['enable_invoices_staff'] =   $request->enable_invoices_staff == 'true' ? 1 : 0;
            }
            if( isset($request->without_background_total)){
                $settings[ 
                    'without_background_total'] =  $request->without_background_total == 'true' ? 1 : 0;
            }
            if( isset($request->template_invoice) && !empty( $request->template_invoice )){
                $settings['template_invoice'] =   $request->template_invoice;
            }
    
            \Log::debug("Array settings " . json_encode($settings));
    
            $fel_restorant->settings = $settings;
    
            $fel_restorant->save();

            return redirect()->route('admin.restaurants.edit', ['restaurant' => $request->restorant_id])->withStatus(__('Se actualizó correctamente las configuraciones.'));


        } catch( Exception $ex ){
            \Log::debug("Ocurrio un error al actulizar las configuraciones " . $ex->getMessage());

            return redirect()->route('admin.restaurants.edit', ['restaurant' => $request->restorant_id])->withError($ex->getMessage());

        }
    } 


    public function updateWhatsappSettings ( Request $request, $restorant_id ){

        try {

            \Log::debug("Request Data >>>>> " . json_encode($request->all()));
    
            $data = [
                'enabled_whatsapp_send' => $request->enabled_whatsapp_send == "true" ? true : false,
                'enabled_whatsapp_auto_send' => $request->enabled_whatsapp_auto_send == "true" ? true : false,
                'has_limit' => $request->has_limit == "true" ? true : false,
                'whatsapp_message_limit' => isset($request->whatsapp_message_limit) ? intval($request->whatsapp_message_limit) : 0 ,
            ];
    
            FelRestorant::where('id', $restorant_id)->update($data);
    
            return redirect()->route('admin.restaurants.edit', ['restaurant' => $request->restorant_id])->withStatus(__('Se actualizó correctamente las configuraciones de Whatsapp.'));

        } catch ( Exception $ex ){

            \Log::debug("Ocurrio un error al actulizar las configuraciones de Whatsapp " . $ex->getMessage());

            return redirect()->route('admin.restaurants.edit', ['restaurant' => $request->restorant_id])->withError($ex->getMessage());

        }


    }


}
