<?php

namespace EmizorIpx\PosInvoicingFel\Services\Invoices\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompraVentaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "montoTotal" => round($this->montoTotal, 2),
            "montoTotalSujetoIva" => round($this->montoTotalSujetoIva, 2),
            "numeroFactura" => $this->numeroFactura,
            "nombreRazonSocial" => $this->nombreRazonSocial,
            "codigoTipoDocumentoIdentidad" => $this->codigoTipoDocumentoIdentidad,
            "numeroDocumento" => $this->numeroDocumento,
            "complemento" => $this->complemento,
            "codigoCliente" => $this->codigoCliente,
            // "codigoMetodoPago" => $this->codigoMetodoPago,
            // "numeroTarjeta" => $this->numeroTarjeta,
            "usuario" => $this->usuario,
            "codigoDocumentoSector" => 1,
            'detalles' => DetalleCompraVentaResource::collection(collect($this->detalles)),
            "emailCliente" => $this->emailCliente,
            // "cafc" => $this->cafc,
            // "descuentoAdicional" => round($this->descuentoAdicional,2),
        ];
    }
}
