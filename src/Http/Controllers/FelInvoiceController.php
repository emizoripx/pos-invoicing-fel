<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers;

use App\Exports\OrdersExport;
use App\Restorant;
use App\User;
use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Jobs\GetInvoiceStatus;
use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceRepository;
use EmizorIpx\PosInvoicingFel\Repository\FelTokenRepository;
use EmizorIpx\PosInvoicingFel\Services\Invoices\FelInvoiceService;
use EmizorIpx\PosInvoicingFel\Utils\ActionTypes;
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

        $invoices = FelInvoice::where('restorant_id', auth()->user()->restorant->id)->whereNotNull('cuf')->orderBy('created_at', 'desc');

        //Get client's orders
        // if (auth()->user()->hasRole('owner')) {
             
        //     //Change currency
        //     ConfChanger::switchCurrency(auth()->user()->restorant);

        //     $orders = $invoices->where(['restorant_id'=>auth()->user()->restorant->id]);
        // }


        //BY DATE FROM
        if (isset($_GET['fromDate']) && strlen($_GET['fromDate']) > 3) {
            $invoices = $invoices->whereDate('created_at', '>=', $_GET['fromDate']);
        }

        //BY DATE TO
        if (isset($_GET['toDate']) && strlen($_GET['toDate']) > 3) {
            $invoices = $invoices->whereDate('created_at', '<=', $_GET['toDate']);
        }

        //FILTER BT status
        // if (isset($_GET['status_id'])) {
        //     $invoices = $invoices->whereHas('laststatus', function($q){
        //         $q->where('status_id', $_GET['status_id']);
        //     });
        // }


        //With downloaod
        // if (isset($_GET['report'])) {
        //     $items = [];
        //     foreach ($invoices->get() as $key => $order) {
        //         $item = [
        //             'order_id'=>$order->id,
        //             'restaurant_name'=>$order->restorant->name,
        //             'restaurant_id'=>$order->restorant_id,
        //             'created'=>$order->created_at,
        //             'last_status'=>$order->status->pluck('alias')->last(),
        //             'client_name'=>$order->client ? $order->client->name : '',
        //             'client_id'=>$order->client ? $order->client_id : null,
        //             'table_name'=>$order->table ? $order->table->name : '',
        //             'table_id'=>$order->table ? $order->table_id : null,
        //             'area_name'=>$order->table && $order->table->restoarea ? $order->table->restoarea->name : '',
        //             'area_id'=>$order->table && $order->table->restoarea ? $order->table->restoarea->id : null,
        //             'address'=>$order->address ? $order->address->address : '',
        //             'address_id'=>$order->address_id,
        //             'driver_name'=>$order->driver ? $order->driver->name : '',
        //             'driver_id'=>$order->driver_id,
        //             'order_value'=>$order->order_price_with_discount,
        //             'order_delivery'=>$order->delivery_price,
        //             'order_total'=>$order->delivery_price + $order->order_price_with_discount,
        //             'payment_method'=>$order->payment_method,
        //             'srtipe_payment_id'=>$order->srtipe_payment_id,
        //             'order_fee'=>$order->fee_value,
        //             'restaurant_fee'=>$order->fee,
        //             'restaurant_static_fee'=>$order->static_fee,
        //             'vat'=>$order->vatvalue,
        //           ];
        //         array_push($items, $item);
        //     }

        //     return Excel::download(new OrdersExport($items), 'orders_'.time().'.xlsx');
        // }

        $invoices = $invoices->paginate(10);

        return view('posinvoicingfel::invoices.index', [
            'invoices' => $invoices,
            'restorants'=>$restorants,
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
