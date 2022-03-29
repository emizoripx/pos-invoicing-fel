<?php

namespace EmizorIpx\PosInvoicingFel\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContingencyReportExport implements FromArray, WithHeadings
{
    protected $data;

    public function headings(): array
    {
        return [
            'NumeroFactura',
            'FechaEmision',
            'NombreRazonSocial',
            'TipoDocumento',
            'NumeroDocumento',
            'Complemento',
            'TelefonoCliente',
            'EmailCliente',
            'MontoTotal',
            'NombreProducto',
            'CodigoProducto',
            'CantidadProducto',
            'PrecioUnitario',
            'MontoDescuentoProducto',
            'Errores'
        ];
    }

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }
}
