<?php

namespace EmizorIpx\PosInvoicingFel\Repository;

use EmizorIpx\PosInvoicingFel\Events\OrderCreated;
use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Exports\ContingencyReportExport;
use EmizorIpx\PosInvoicingFel\Models\FelContingencyFile;
use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Models\FelInvoiceAux;
use EmizorIpx\PosInvoicingFel\Utils\ContingencyFileStatus;
use EmizorIpx\PosInvoicingFel\Utils\MakeOrderUtils;
use Illuminate\Support\Facades\Storage;

use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use EmizorIpx\PosInvoicingFel\Jobs\GetInvoiceStatus;
use EmizorIpx\PosInvoicingFel\Utils\ActionTypes;
use Exception;

class FelInvoiceAuxRepository {

    protected $provider = FelInvoiceAux::class;

    protected $cafc_code;

    public function setCafcCode($value){

        $this->cafc_code = $value;

    }

    
    public function processInvoices ($file_id){

        try {

            $list_invoices_error = [];
            $order = null;

            $fel_order_aux = \DB::table('fel_invoices_aux')->where('file_id', $file_id)->get();
            
            // \Log::debug("Aux Invoices >>>>>> " . json_encode($fel_order_aux));

            $fel_invoice_details =  \DB::table('fel_invoices_aux')->where('file_id', $file_id)->select('numeroFactura', 'product_nombre', 'product_codigoProducto', 'product_cantidad', 'product_precioUnitario', 'product_montoDescuento', 'item_id')->get();
            
            $group_order = collect( $fel_order_aux )->groupBy('numeroFactura')->all();
            $group_details = collect( $fel_invoice_details )->groupBy('numeroFactura')->all();

            $list_orders = collect($group_order)->map( function ( $item) use ($group_details){
                
                \Log::debug("Items   " . json_encode($item));
                
                $order_aux = collect($item[0])->only(['restorant_id', 'numeroFactura', 'fechaEmision', 'nombreRazonSocial', 'codigoTipoDocumentoIdentidad', 'numeroDocumento', 'complemento', 'codigoMetodoPago', 'usuario', 'montoTotal', 'telefonoCliente', 'emailCliente'])->all();
                
                $order_aux['detalle'] = $group_details[ $order_aux['numeroFactura'] ];

                return $order_aux;

            })->values();
            
            // \Log::debug("Group Aux Invoices >>>>>> " . json_encode($group_order));
            // \Log::debug("List Orders  >>>>>> " . json_encode($list_orders));


            foreach ($list_orders as $order_data) {
                try {

                    $order_record = MakeOrderUtils::makeOrder($order_data);
    
                    OrderCreated::dispatch($order_record, MakeOrderUtils::prepareFelData($order_data, $this->cafc_code, $file_id));
    
                    $fel_invoice = FelInvoice::where('order_id', $order_record->id)->first();
    
                    $fel_invoice->emitInContingency();
                    
                    GetInvoiceStatus::dispatch($fel_invoice, ActionTypes::EMIT)->delay( now()->addSeconds(5) );
    
                    \DB::table('fel_cafc_codes')->where('cafc', $this->cafc_code)->where('restorant_id', $fel_invoice->restorant_id)->update([
                        'last_number_applied' => $fel_invoice->numeroFactura
                    ]);
    
                    \DB::table('fel_invoices_aux')->where('restorant_id', $fel_invoice->restorant_id)->where('file_id', $file_id)->where('numeroFactura', $fel_invoice->numeroFactura)->delete();
                } catch( PosInvoicingException | Exception $exec ){
                    \Log::debug("Error al procesar Facturas " . $exec->getMessage() . "File ". $exec->getFile() . " Line " . $exec->getLine());

                    // $order['error'] = $ex->getMessage();
                    $order_data = array_merge($order_data, [
                        'error' => $exec->getMessage()
                    ]);
    
                    array_push($list_invoices_error, $order_data);
                    
                }


            }


        } catch( PosInvoicingException | Exception $ex ){
            \Log::debug("Error al procesar Facturas " . $ex->getMessage() . "File ". $ex->getFile() . " Line " . $ex->getLine());

            

            // throw new Exception($ex->getMessage());
        }

        return $list_invoices_error;

    }

    public function makeErrorsReport ( $file_id, $error_invoices, $file_name, $restorant_id ){

        $invoice_error = \DB::table('fel_invoices_aux')->where('file_id', $file_id)->where('restorant_id', $restorant_id)->select('numeroFactura', 'fechaEmision', 'nombreRazonSocial', 'codigoTipoDocumentoIdentidad', 'numeroDocumento', 'numeroDocumento', 'complemento', 'telefonoCliente', 'emailCliente', 'montoTotal', 'product_nombre', 'product_codigoProducto', 'product_cantidad', 'product_precioUnitario', 'product_montoDescuento')->get();

        $group_invoices = collect( $error_invoices )->groupBy('numeroFactura')->all();

        // \Log::debug("Result Errors Invoices >>>>>>> " . json_encode($group_invoices));

        $invoices_to_export = collect( $invoice_error )->map( function($item) use ($group_invoices){

            $item_r = collect( $item )->merge([ "error" => isset($group_invoices[$item->numeroFactura]) ? $group_invoices[$item->numeroFactura][0]['error'] : ''  ]);

            return $item_r;

        })->all();

        $time = str_replace([' ', ':'], '_' ,Carbon::now());
        $base_file_path = "contingeny-files/$restorant_id/reports/Reporte_" . $time .'_' . $file_name;

        $path = Excel::store( new ContingencyReportExport($invoices_to_export), $base_file_path , 's3', \Maatwebsite\Excel\Excel::CSV );

        \Log::debug("Path >>>>>>>> " . $path);

        \DB::table('fel_contingency_files')->where('id', $file_id)->update([
            'error_report_path' => $base_file_path
        ]);


        $this->removeRegisters($file_id, $restorant_id);

    }

    public function removeRegisters( $file_id, $restorant_id ) {

        return \DB::table('fel_invoices_aux')->where('file_id', $file_id)->where('restorant_id', $restorant_id)->delete();
    }

}