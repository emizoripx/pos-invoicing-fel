<?php

namespace EmizorIpx\PosInvoicingFel\Repository;

use EmizorIpx\PosInvoicingFel\Events\OrderCreated;
use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelContingencyFile;
use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Models\FelInvoiceAux;
use EmizorIpx\PosInvoicingFel\Utils\ContingencyFileStatus;
use EmizorIpx\PosInvoicingFel\Utils\MakeOrderUtils;
use Illuminate\Support\Facades\Storage;
use Exception;

class FelInvoiceAuxRepository {

    protected $provider = FelInvoiceAux::class;

    protected $cafc_code;

    public function setCafcCode($value){

        $this->cafc_code = $value;

    }

    
    public function processInvoices ($file_id){

        try {

            $fel_order_aux = \DB::table('fel_invoices_aux')->where('file_id', $file_id)->get();
            
            \Log::debug("Aux Invoices >>>>>> " . json_encode($fel_order_aux));

            $fel_invoice_details =  \DB::table('fel_invoices_aux')->where('file_id', $file_id)->select('numeroFactura', 'product_nombre', 'product_codigoProducto', 'product_cantidad', 'product_precioUnitario', 'product_montoDescuento', 'item_id')->get();
            
            $group_order = collect( $fel_order_aux )->groupBy('numeroFactura')->all();
            $group_details = collect( $fel_invoice_details )->groupBy('numeroFactura')->all();

            $list_orders = collect($group_order)->map( function ( $item) use ($group_details){
                
                \Log::debug("Items   " . json_encode($item));
                
                $order_aux = collect($item[0])->only(['restorant_id', 'numeroFactura', 'fechaEmision', 'nombreRazonSocial', 'codigoTipoDocumentoIdentidad', 'numeroDocumento', 'complemento', 'codigoMetodoPago', 'usuario', 'montoTotal', 'telefonoCliente', 'emailCliente'])->all();
                
                $order_aux['detalle'] = $group_details[ $order_aux['numeroFactura'] ];

                return $order_aux;

            })->values();
            
            \Log::debug("Group Aux Invoices >>>>>> " . json_encode($group_order));
            \Log::debug("List Orders  >>>>>> " . json_encode($list_orders));


            foreach ($list_orders as $order_data) {

                $order_record = MakeOrderUtils::makeOrder($order_data);

                OrderCreated::dispatch($order_record, MakeOrderUtils::prepareFelData($order_data, $this->cafc_code));

                $fel_invoice = FelInvoice::where('order_id', $order_record->id)->first();

                $fel_invoice->emitInContingency();


                \DB::table('fel_cafc_codes')->where('cafc', $this->cafc_code)->where('restorant_id', $fel_invoice->restorant_id)->update([
                    'last_number_applied' => $fel_invoice->numeroFactura
                ]);

                

            }


        } catch( PosInvoicingException | Exception $ex ){
            \Log::debug("Error al procesar Facturas " . $ex->getMessage());

            throw new Exception($ex->getMessage());
        }

    }

}