<?php

namespace EmizorIpx\PosInvoicingFel\Repository;

use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use stdClass;

class FelInvoiceRepository {

    protected $data = [];

    public function prepareData($order, $fel_data){
        $array_data = [
            'restorant_id' => $order->restorant_id,
            'order_id' => $order->id,
            'numeroFactura' => $order->id,
            'nombreRazonSocial' => $fel_data['nombreRazonSocial'],
            'codigoTipoDocumentoIdentidad' => 1,
            'numeroDocumento' => $fel_data['numeroDocumento'],
            'codigoMetodoPago' => 1,
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
            // $new->codigoProducto = $item->codigo_producto;
            $new->descripcion = $item->name;
            $new->cantidad = $item->pivot->qty;
            $new->precioUnitario = $item->price;
            $new->subTotal = $item->price * $item->pivot->qty;
            $new->montoDescuento = 0;
            $new->unidadMedida = 58;

            $array_details[] = $new;
        }

        $this->data['detalles'] = $array_details;
    }

    public function create(){
        \Log::debug("Data To Save >>>>>>>>>>>>>>>>>>>>>>");
        \Log::debug(json_encode($this->data));
        FelInvoice::create($this->data);
    }

}