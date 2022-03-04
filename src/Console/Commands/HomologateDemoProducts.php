<?php

namespace EmizorIpx\PosInvoicingFel\Console\Commands;

use App\Categories;
use App\Items;
use App\Restorant;
use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelProduct;
use EmizorIpx\PosInvoicingFel\Models\FelSinProduct;
use EmizorIpx\PosInvoicingFel\Repository\ParametricRepository;
use Exception;
use Illuminate\Console\Command;

class HomologateDemoProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emizor:homologate-demo {restorant_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Homologate Demo Products';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle( )
    {
        try{

            $restorant_id = $this->argument('restorant_id');
            $restorant = Restorant::where('id', $restorant_id)->first();

            if(empty($restorant)){
                $this->error('Restaurant #' . $restorant_id . ' no existe');
            }

            $product_sin = FelSinProduct::where('restorant_id', $restorant_id)->first();

            if(empty($product_sin)){
                $this->error('No tiene catálogo de Productos SIN');
            }

            $categories_id = Categories::where('restorant_id', $restorant_id)->pluck('id')->all() ;

            \Log::debug("Categories ID >>>>>>>>>>>>>>>>");
            \Log::debug($categories_id);

            $items = Items::whereIn('category_id',$categories_id)->select('id', 'codigoProducto', 'name')->get();

            $items_homologate = [];

            foreach ($items as $item) {
                $item_holomogate = [];
                $item_holomogate['item_id'] = $item->id ;
                $item_holomogate['restorant_id'] = $restorant_id ;
                $item_holomogate['codigoUnidad'] = 58 ;
                $item_holomogate['codigoProducto'] = is_null($item->codigoProducto) ? strtoupper(substr($item->name, 0, 3)) . '-'. strval(time()) : $item->codigoProducto;
                $item_holomogate['codigoProductoSin'] = $product_sin->codigo ;
                $item_holomogate['codigoActividadEconomica'] = $product_sin->codigoActividad ;

                $items_homologate[] = $item_holomogate;
            }

            \Log::debug("Products to Save >>>>>>>>>>>>>>> " . json_encode($items_homologate));

            FelProduct::upsert($items_homologate, ['item_id'], ['codigoUnidad', 'codigoProductoSin', 'codigoActividadEconomica', 'codigoProducto']);

            $this->info('Homologación Finalida con Éxito');

        } catch(PosInvoicingException | Exception $ex){
            \Log::debug("Error en la Homologación de Productos: " . $ex->getMessage() . " Linea " . $ex->getLine());
            $this->error($ex->getMessage());
        }
    }
}
