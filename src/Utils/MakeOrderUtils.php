<?php

namespace EmizorIpx\PosInvoicingFel\Utils;

use App\Repositories\Orders\OrderRepoGenerator;
use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use Illuminate\Http\Request;

class MakeOrderUtils {


    public static function makeOrder( $data ){

        $data_request = static::prepareOrderData( $data );

        $order_repo = OrderRepoGenerator::makeOrderRepo( $data['restorant_id'], $data_request, $data_request->delivery_method, false, false, true, null, "POS");

        $validator = $order_repo->validateData();

        if( $validator->fails()){
            \Log::debug("Errores de validacion de datos " . $validator->errors()->first());

            throw new PosInvoicingException('Error validación de datos: ' . $validator->errors()->first());
        }

        $validatorOnMaking = $order_repo->makeOrder();

        if( $validatorOnMaking->fails() ){
            \Log::debug("Errores al crear la Orden ". $validatorOnMaking->errors()->first());

            throw new PosInvoicingException('Al crear la orden : ' . $validatorOnMaking->errors()->first());
        }

        $order = $order_repo->order;

        $order->created_at = $data['fechaEmision'];
        $order->updated_at = $data['fechaEmision'];
        $order->employee_id = intval($data['usuario']);
        $order->save();


        return $order->refresh();


    }


    public static function prepareOrderData( $data ){

        $data = [
            'vendor_id' => $data['restorant_id'],
            'delivery_method' => 'pickup',
            'payment_method' => 'cash',
            'address_id' => null,
            'timeslot' => '0_0',
            'items' => static::prepareOrderDetail($data['detalle']),
            'comment' => '',
            'stripe_token' => null,
            'dinein_table_id' => null,
            'phone' => $data['telefonoCliente'],
            'customFields' => '',
            'coupon_code' => null,
        ];

        return new Request($data);

    }

    public static function prepareOrderDetail( $data_detail ){

        $items = [];

        foreach ($data_detail as $detail) {
            array_push( $items, [
                "id"=>$detail->item_id,
                "qty"=>$detail->product_cantidad,
                "variant"=>'',
                "extrasSelected"=>[]
            ] );
        }

        return $items ;
    }

    public static function prepareFelData($data, $cafc){

        return [
            'codigoTipoDocumentoIdentidad' => $data['codigoTipoDocumentoIdentidad'],
            'codigoMetodoPago' => $data['codigoMetodoPago'],
            'nombreRazonSocial' => is_null($data['nombreRazonSocial']) ? 'CONTROL TRIBUTARIO' : $data['nombreRazonSocial'] ,
            'numeroDocumento' => is_null($data['nombreRazonSocial']) ? '99002' : $data['numeroDocumento'] ,
            'complemento' => $data['complemento'],
            'email_client' => $data['emailCliente'],
            'phone_number' => $data['telefonoCliente'],
            'cafc' => $cafc,
            'fechaEmision' => $data['fechaEmision'],
            'numeroFactura' => $data['numeroFactura']
            
        ];

    }


}