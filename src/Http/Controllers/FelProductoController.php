<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers;

use EmizorIpx\PosInvoicingFel\Exports\ProductsExport;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class FelProductoController{

    public function export(Request $request, $restorant_id)
    {

        $fel_products = \DB::table('items')->join('fel_products', 'fel_products.item_id', 'items.id')
                                ->where('fel_products.restorant_id', $restorant_id)
                                ->select('fel_products.id as id', 'items.name as nombre', 'fel_products.codigoProducto as codigoProducto', 'items.price as precio')
                                ->get();

        if(empty($fel_products)){
            return redirect()->back()->withStatus('No Hay Productos para Exportar');
        }

        return Excel::download(new ProductsExport (json_decode($fel_products)), 'productos_'.time().'.csv', \Maatwebsite\Excel\Excel::CSV);
        
    }

}
