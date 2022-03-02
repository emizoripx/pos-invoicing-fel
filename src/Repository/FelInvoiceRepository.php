<?php

namespace EmizorIpx\PosInvoicingFel\Repository;

use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Utils\EmissionTypes;
use stdClass;

class FelInvoiceRepository {

    protected $data = [];

    protected $invoice_model;

    public function prepareData($order, $fel_data){
        $array_data = [
            'restorant_id' => $order->restorant_id,
            'order_id' => $order->id,
            'numeroFactura' => $order->id,
            'nombreRazonSocial' => $fel_data['nombreRazonSocial'],
            'codigoTipoDocumentoIdentidad' => isset($fel_data['codigoTipoDocumentoIdentidad']) ? $fel_data['codigoTipoDocumentoIdentidad'] : 1 ,
            'numeroDocumento' => $fel_data['numeroDocumento'],
            'codigoMetodoPago' => isset($fel_data['codigoMetodoPago']) ? $fel_data['codigoMetodoPago'] : 1,
            'complemento' => isset($fel_data['complemento']) ? $fel_data['complemento'] : null,
            'usuario' => $order->employee_id,
            'montoTotal' => $order->order_price,
            'codigoCliente' => '',
            'montoTotalSujetoIva' => $order->order_price,
        ];

        $this->data = array_merge($this->data, $array_data);
    }

    public function prepareDetailsData( $items ){
        $array_details = [];

        foreach ($items as $item) {
            $new = new stdClass();
            $new->codigoProducto = is_null($item->codigoProducto) ? $item->fel_product->codigoProducto :  $item->codigoProducto  ;
            $new->descripcion = $item->name;
            $new->cantidad = $item->pivot->qty;
            $new->precioUnitario = $item->pivot->variant_price;
            $new->subTotal = $item->pivot->variant_price * $item->pivot->qty;
            $new->montoDescuento = 0;
            $new->unidadMedida = isset($item->fel_product) ? $item->fel_product->codigoUnidad : 58;

            $extras = json_decode($item->pivot->extras);

            if(count($extras) > 0){
                $data_extra = implode(' - ', $extras) ;
                $new->descripcion .= ' - ' . $data_extra;
            }

            $array_details[] = $new;
        }

        $this->data['detalles'] = $array_details;
    }

    public function addDeliveryItem( $price ){

        $array_detail = [];

        $new = new stdClass();
        $new->codigoProducto = 'DEL-2122331';
        $new->descripcion = 'Delivery';
        $new->cantidad = 1;
        $new->precioUnitario = $price;
        $new->subTotal = $price;
        $new->montoDescuento = 0;
        $new->unidadMedida = 58;

        $array_detail[] = $new;

        $this->data['detalles'] = array_merge($this->data['detalles'], $array_detail);

        $this->data['montoTotal'] = $this->data['montoTotal'] + $price;
        $this->data['montoTotalSujetoIva'] = $this->data['montoTotalSujetoIva'] + $price;


    }

    public function parseResponseToSave($data){
        $array_data = [
            'cuf' => $data['cuf'],
            'url_sin' => $data['urlSin'],
            'tipoEmision' => EmissionTypes::DESCRIPTION[$data['emission_type_code']] ,
            'leyenda' => $data['leyenda'],
            'direccion' => $data['direccion'],
            'nitEmisor' => $data['nitEmisor'],
            'municipio' => $data['municipio'],
            'fechaEmision' => $data['fechaEmision'],
            'razonSocialEmisor' => $data['razonSocialEmisor'],
            'telefonoEmisor' => $data['telefonoEmisor'],
            'montoLiteral' => $data['montoLiteral'],
        ];

        $this->data = $array_data;
    }

    public function parseStatusResponse($data){

        $array_data = [
            'codigoEstado' => $data['codigoEstado'],
            'estado' => $data['estado'],
            'errores' => is_null($data['errores']) ? null : $data['errores'] ,
        ];

        $this->data = $array_data;

    }

    public function create(){
        \Log::debug("Data To Save >>>>>>>>>>>>>>>>>>>>>>");
        \Log::debug(json_encode($this->data));
        FelInvoice::create($this->data);
    }

    public function update( FelInvoice $model ){
        $model->update($this->data );

        return $model;
    }


    public function get($order_id){

        $invoice = FelInvoice::where('order_id', $order_id)->first();

        return $invoice;

    }

}