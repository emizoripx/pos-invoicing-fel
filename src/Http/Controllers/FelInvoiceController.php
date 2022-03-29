<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers;

use App\Exports\OrdersExport;
use App\Restorant;
use App\User;
use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Exports\FelInvoicesExport;
use EmizorIpx\PosInvoicingFel\Jobs\GetInvoiceStatus;
use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceRepository;
use EmizorIpx\PosInvoicingFel\Repository\FelTokenRepository;
use EmizorIpx\PosInvoicingFel\Services\Invoices\FelInvoiceService;
use EmizorIpx\PosInvoicingFel\Utils\ActionTypes;
use EmizorIpx\PosInvoicingFel\Utils\StatusCodeInvoice;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class FelInvoiceController extends Controller
{
    protected $felinvoice_repo;

    protected $feltoken_repo;

    public function __construct( FelInvoiceRepository $felinvoice_repo, FelTokenRepository $feltoken_repo )
    {
        $this->felinvoice_repo = $felinvoice_repo;    
        $this->feltoken_repo = $feltoken_repo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $restorants = Restorant::where(['active'=>1])->get();
        // $drivers = User::role('driver')->where(['active'=>1])->get();

        // $driversData = [];
        // foreach ($drivers as $key => $driver) {
        //     $driversData[$driver->id] = $driver->name;
        // }

        $invoices = FelInvoice::where('restorant_id', auth()->user()->restorant->id)->whereNotNull('cuf')->orderBy('fechaEmision', 'desc');

        //Get client's orders
        // if (auth()->user()->hasRole('owner')) {
             
        //     //Change currency
        //     ConfChanger::switchCurrency(auth()->user()->restorant);

        //     $orders = $invoices->where(['restorant_id'=>auth()->user()->restorant->id]);
        // }


        //BY DATE FROM
        if (isset($_GET['fromDate']) && strlen($_GET['fromDate']) > 3) {
            $invoices = $invoices->whereDate('fechaEmision', '>=', $_GET['fromDate']);
        }

        //BY DATE TO
        if (isset($_GET['toDate']) && strlen($_GET['toDate']) > 3) {
            $invoices = $invoices->whereDate('fechaEmision', '<=', $_GET['toDate']);
        }

        // BY STATE
        if (isset($_GET['state_invoice']) && strlen($_GET['state_invoice']) > 2) {
            $invoices = $invoices->where('codigoEstado', '=', intval($_GET['state_invoice']));
        }

        //FILTER BT status
        // if (isset($_GET['status_id'])) {
        //     $invoices = $invoices->whereHas('laststatus', function($q){
        //         $q->where('status_id', $_GET['status_id']);
        //     });
        // }


        //With downloaod
        if (isset($_GET['report'])) {
            $items = [];
            foreach ($invoices->get() as $key => $invoice) {
                $item = [
                    'numero_factura'=>$invoice->numeroFactura,
                    'numero_orden'=>$invoice->order_id,
                    'cuf'=>$invoice->cuf,
                    'fecha_emision'=>$invoice->fechaEmision,
                    'nombre_razon_social'=>$invoice->nombreRazonSocial,
                    'numero_documento'=>$invoice->numeroDocumento,
                    'complemento'=>$invoice->complemento,
                    'codigo_cliente'=>$invoice->codigoCliente,
                    'monto_total'=> (float) $invoice->montoTotal,
                    'monto_total_sujeto_iva'=> (float) $invoice->montoTotalSujetoIva,
                    'estado'=>$invoice->estado,
                    'codigo_estado'=>$invoice->codigoEstado,
                    'tipo_emision'=>$invoice->tipoEmision,
                    'url_sin'=>$invoice->url_sin,
                    'creado'=>$invoice->created_at,
                  ];
                array_push($items, $item);
            }

            return Excel::download(new FelInvoicesExport($items), 'facturas_'.time().'.xlsx');
        }

        $invoices = $invoices->paginate(10);

        return view('posinvoicingfel::invoices.index', [
            'invoices' => $invoices,
            'restorants'=>$restorants,
            'states'=> StatusCodeInvoice::INVOICE_STATES,
            // 'fields'=>[['class'=>'col-12', 'classselect'=>'noselecttwo', 'ftype'=>'select', 'name'=>'Driver', 'id'=>'driver', 'placeholder'=>'Assign Driver', 'data'=>$driversData, 'required'=>true]],
            'parameters'=>count($_GET) != 0,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    
    public function store(Request $request){

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
        //
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
