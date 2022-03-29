<?php

namespace EmizorIpx\PosInvoicingFel\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromArray, WithHeadings
{
    protected $data;

    public function headings(): array
    {
        return [
            'ID',
            'NombreProducto',
            'CodigoProducto',
            'Precio',
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
