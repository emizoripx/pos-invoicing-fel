<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers;

use EmizorIpx\PosInvoicingFel\Http\Resources\ParametricResource;
use EmizorIpx\PosInvoicingFel\Repository\ParametricRepository;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class ParametricController extends Controller
{
    protected $parametric_repo;

    public function __construct( ParametricRepository $parametric_repo )
    {
        $this->parametric_repo = $parametric_repo;    
    }

    public function get( Request $request, $type_parametric ){
        
        try{

            \Log::debug("Get Parametrics >>>>>>>>>>>>>>>>> ");

            $parametrics = $this->parametric_repo->get($type_parametric);
    
            if(is_null($parametrics)){
                throw new Exception('No se encontro parametricas');
            }
    
            return response()->json([
                'status' => true,
                'data'=> ParametricResource::collection($parametrics)
            ]);
        } catch( Exception $ex ){
            return response()->json([
                'status' => false,
                'message'=> $ex->getMessage()
            ]);
        }

    }

}
