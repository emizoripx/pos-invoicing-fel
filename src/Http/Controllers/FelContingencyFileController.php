<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers;

use App\Exports\OrdersExport;
use App\Restorant;
use App\User;
use EmizorIpx\PosInvoicingFel\Models\FelContingencyFile;
use EmizorIpx\PosInvoicingFel\Repository\FelContingencyFileRepository;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Maatwebsite\Excel\Facades\Excel;

class FelContingencyFileController extends Controller
{
    protected $contingency_file_repo ;

    public function __construct( FelContingencyFileRepository $contingency_file_repo )
    {
        $this->contingency_file_repo = $contingency_file_repo;
    }

    private function authChecker(){

        if (! auth()->user()->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }
    }

    private function getFields(){

        $cafc_codes = \DB::table('fel_cafc_codes')->where('restorant_id', auth()->user()->restorant->id)->pluck('description', 'id')->all();

        return [
            ['class'=>'col-md-4', 'ftype'=>'select', 'name'=>'Talonario', 'id'=>'cafc_id', 'placeholder'=>'Selecionar un Talonario', 'data'=> $cafc_codes, 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'input', 'type'=>'file', 'name'=>'Desde', 'id'=>'file', 'accept'=>'.csv,.xlsx,.xlsx', 'placeholder'=>'Selecionar un Archivo', 'required'=>true],
        ];

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $contingency_files = FelContingencyFile::where('restorant_id', auth()->user()->restorant->id)->orderBy('created_at', 'desc')->paginate(10);

        return view('posinvoicingfel::contingency.index', [
            'contingency_files' => $contingency_files,
            'action_link' => route('contingency.create'),
            'action_name'=>__('crud.add_new_item', ['item'=>__('Archivo')]),
            'action_link2' => route('cafc.index'),
            'action_name2'=>__('CAFC'),
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

        return view('posinvoicingfel::contingency.create', [ 
                    'setup' => [
                        'action' => route('contingency.store'),
                        'action_link'=>route('contingency.index'),
                        'action_name'=>__('crud.back'),
                    ],
                    'fields_row' => $fields
                ]);

    }

    
    public function store(Request $request){

        \Log::debug("Data >>>> ");
        \Log::debug($request->all());

        try{

            if ( !$request->hasFile('file')){
                throw new Exception("No existe ningún archivo");
            }

            $this->contingency_file_repo->processRequest($request);

            return redirect()->route('contingency.index')->withStatus(__('Archivo guardado correctamente y se inició el proceso.'));

        } catch(Exception $ex){
            \Log::debug("Error al subir el Archivo: " . $ex->getMessage());

            return redirect()->back()->withError('Error al cargar el Arachivo');

        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FelContingencyFile $file)
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
        return Storage::disk('s3')->download('contingeny-files/21/files/yOCdbubPn3rB8ug39WOQZ4KoHddXYU5jIVRIRhRF.txt');
        // \Log::debug($file);
        // header("Cache-Control: public");
        // header("Content-Description: File Transfer");
        // header("Content-Disposition: attachment; filename=facturas.csv");
        // header("Content-Type: text/csv");
        // return readfile($file);
    }

    /**
     * Update the order item count
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Order $order)
    {

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
