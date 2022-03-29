<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers;

use App\Exports\OrdersExport;
use App\Restorant;
use App\User;
use EmizorIpx\PosInvoicingFel\Models\FelCafcCode;
use EmizorIpx\PosInvoicingFel\Models\FelContingencyFile;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class FelCafcCodeController extends Controller
{

    private $provider = FelCafcCode::class;



    public function __construct()
    {
    }

    private function authChecker()
    {
        if (! auth()->user()->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }
    }


    public function getFields(){
        return [
            'row_one' =>[
                ['class'=>'col-md-4', 'ftype'=>'input', 'name'=>'Código CAFC', 'id'=>'cafc', 'placeholder'=>'Código CAFC', 'required'=>true],
                ['class'=>'col-md-4', 'ftype'=>'input', 'name'=>'Descripción', 'id'=>'description', 'placeholder'=>'Descripción', 'required'=>true]
            ],
            'row_two' => [
                ['class'=>'col-md-4', 'ftype'=>'input', 'type'=>'number', 'name'=>'Desde', 'id'=>'from_invoice_number', 'placeholder'=>'Número Factura Inicial de Talonario', 'required'=>true],
                ['class'=>'col-md-4', 'ftype'=>'input', 'type'=>'number', 'name'=>'Hasta', 'id'=>'to_invoice_number', 'placeholder'=>'Número Factura Final de Talonario', 'required'=>true],
            ]
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authChecker();

        $cafcs = FelCafcCode::where('restorant_id', auth()->user()->restorant->id)->orderBy('created_at', 'asc')->paginate(10);

        return view('posinvoicingfel::cafc.index', [
            'cafcs' => $cafcs,
            'action_link' => route('cafc.create'),
            'action_name'=>__('crud.add_new_item', ['item'=>__('CAFC')]),
            'action_link2' => route('contingency.index'),
            'action_name2'=>__('Archivos'),
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authChecker();

        $fields = $this->getFields();

        return view('posinvoicingfel::cafc.create', [ 
            'setup' => [
                'action' => route('cafc.store'),
                'action_link'=>route('cafc.index'),
                'action_name'=>__('crud.back'),
            ],
            'fields_row1' => $fields['row_one'],
            'fields_row2' => $fields['row_two'],
        ]);

    }

    
    public function store(Request $request){

        try{
            
            $item = $this->provider::create([
                'cafc' => $request->cafc,
                'description' => $request->description,
                'from_invoice_number' => $request->from_invoice_number,
                'to_invoice_number' => $request->to_invoice_number,
                'restorant_id' => auth()->user()->restorant->id
            ]);

            return redirect()->route('cafc.index')->withStatus(__('Código CAFC creado con éxito.'));

        } catch(Exception $ex){

            \Log::debug("Error al crear código CAFC: " . $ex->getMessage());

            return redirect()->back()->withError('Error al Crear Código CAFC');
        }


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $this->authChecker();

        $cafc = $this->provider::findOrFail($id);

        $fields = $this->getFields();

        $fields['row_one'][0]['value'] = $cafc->cafc;
        $fields['row_one'][1]['value'] = $cafc->description;
        $fields['row_two'][0]['value'] = $cafc->from_invoice_number;
        $fields['row_two'][1]['value'] = $cafc->to_invoice_number;

        return view('posinvoicingfel::cafc.update', [ 
            'setup' => [
                'action' => route('cafc.update', $cafc->id),
                'action_link'=>route('cafc.index'),
                'action_name'=>__('crud.back'),
                'isupdate'=>true,
            ],
            'fields_row1' => $fields['row_one'],
            'fields_row2' => $fields['row_two'],
        ]);

    }

    /**
     * Update the order item count
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $this->authChecker();
    
            $cafc = $this->provider::findOrFail($id);
    
            $cafc->cafc = $request->cafc;
            $cafc->description = $request->description;
            $cafc->from_invoice_number = $request->from_invoice_number;
            $cafc->to_invoice_number = $request->to_invoice_number;
    
            $cafc->save();

            return redirect()->route('cafc.index')->withStatus(__('Código CAFC Actualizado con éxito.'));

        } catch ( Exception $ex ){
            \Log::debug("Error al Actualizar CAFC . " . $ex->getMessage());

            return redirect()->back()->withError('Error al Actualizar Código CAFC');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    
}
