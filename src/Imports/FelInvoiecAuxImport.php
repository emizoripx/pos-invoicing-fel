<?php

namespace EmizorIpx\PosInvoicingFel\Imports;

use App\Categories;
use App\Items;
use App\Restorant;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Carbon\Carbon;
use EmizorIpx\PosInvoicingFel\Models\FelInvoiceAux;
use EmizorIpx\PosInvoicingFel\Utils\IdentityDocument;

class FelInvoiecAuxImport implements ToModel, WithHeadingRow
{
    protected $restorant;

    protected $user_id;

    protected $items;

    protected $number_invoice;

    protected $emission_date;

    protected $second_increment = 1;

    protected $file_id;

    protected $cafc_from;

    protected $cafc_to;

    public function __construct( Restorant $restorant, $user_id, $file_id, $cafc_from, $cafc_to)
    {
        \Log::debug("Items ");
        \Log::debug(json_encode($restorant->fel_restorant->fel_products));
        $this->restorant = $restorant;
        $this->items = $restorant->fel_restorant->fel_products;
        $this->number_invoice = null;
        $this->emission_date = null;
        $this->user_id = $user_id;
        $this->file_id = $file_id;

        $this->cafc_from = $cafc_from;
        $this->cafc_to = $cafc_to;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        \Log::debug(json_encode($row));
        $date_parsed = Carbon::parse($row['fechaemision']);

        \Log::debug("Number invoice ". $this->number_invoice);
        \Log::debug("Date invoice ". $this->emission_date);
        
        if( !is_null($this->number_invoice) && intval($row['numerofactura']) < $this->number_invoice ){
            throw new Exception('Error de correlatividad en numeración de la Factura');
        }

        if( intval($row['numerofactura']) < $this->cafc_from || intval($row['numerofactura']) > $this->cafc_to ) {

            throw new Exception('Número de Factura #' . intval($row['numerofactura']) . 'Fuera de Rango de Talonario');

        }

        

        if( is_null($this->emission_date) ){
            $this->emission_date = $date_parsed;
        }

        $date_parsed_aux = $date_parsed;

        if( $date_parsed->equalTo($this->emission_date) ){
            $date_parsed = $date_parsed->addSeconds($this->second_increment);
            $this->second_increment += 1;
        } else {
            $this->second_increment = 1;
        }


        
        if ( $date_parsed->lessThan($this->emission_date) && intval($row['numerofactura']) != $this->number_invoice ){
            throw new Exception('Error de correlatividad en fecha de Emision de la Factura #' . $row['numerofactura']);
        }

        $this->emission_date = $date_parsed_aux;
        $this->number_invoice = intval($row['numerofactura']);

       $item = $this->items->where('codigoProducto', $row['codigoproducto'])->first();

        if( ! empty($item) ){

            return new FelInvoiceAux([
                'restorant_id' => $this->restorant->id,
                'file_id' => $this->file_id,
                'user_id' => $this->user_id,
                'numeroFactura' => $row['numerofactura'],
                'fechaEmision' => $date_parsed,
                'nombreRazonSocial' => ($row['nombrerazonsocial']),
                'codigoTipoDocumentoIdentidad' => IdentityDocument::getIdentityDocumentCode($row['tipodocumento']),
                'numeroDocumento' => $row['numerodocumento'],
                'complemento' => $row['complemento'],
                'codigoMetodoPago' => 1,
                'usuario' => $this->user_id,
                'montoTotal' => $row['montototal'],
                'codigoCliente' => '',
                'telefonoCliente' => $row['telefonocliente'],
                'emailCliente' => $row['emailcliente'],

                'product_nombre' => $row['nombreproducto'],
                'product_codigoProducto' => $row['codigoproducto'],
                'item_id' => $item->item_id,
                'product_cantidad' => $row['cantidadproducto'],
                'product_precioUnitario' => $row['preciounitarioproducto'],
                'product_montoDescuento' => $row['montodescuentoproducto'],

            ]);

        } else {
            \Log::debug("No existe Producto ". $row['codigoproducto']);

            throw new Exception("No existe el Producto " . $row['codigoproducto']);
        }
        


    }
}
