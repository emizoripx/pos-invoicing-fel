<?php

namespace EmizorIpx\PosInvoicingFel\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FelInvoicesExport implements FromArray, WithHeadings
{
    protected $fel_invoices;

    public function headings(): array
    {
        return [
            'numero_factura',
            'numero_orden',
            'cuf',
            'fecha_emision',
            'nombre_razon_social',
            'numero_documento',
            'complemento',
            'codigo_cliente',
            'monto_total',
            'monto_total_sujeto_iva',
            'estado',
            'codigo_estado',
            'tipo_emision',
            'url_sin',
            'creado',
        ];
    }

    public function __construct(array $fel_invoices)
    {
        $this->fel_invoices = $fel_invoices;
    }

    public function array(): array
    {
        return $this->fel_invoices;
    }
}
