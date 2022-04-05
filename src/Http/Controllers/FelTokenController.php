<?php

namespace EmizorIpx\PosInvoicingFel\Http\Controllers;

use App\Restorant;
use App\User;
use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Models\FelToken;
use EmizorIpx\PosInvoicingFel\Repository\FelTokenRepository;
use EmizorIpx\PosInvoicingFel\Services\Credentials\CredentialsService;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class FelTokenController extends Controller
{
    protected $fel_token_repo  ;

    public function __construct( FelTokenRepository $fel_token_repo )
    {
        $this->fel_token_repo = $fel_token_repo;
        
    }

    public function checkauth(){
        if (! auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.restaurants.edit')->withStatus(__('No Access'));
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
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

        try {

            \Log::debug("Request >>>>>>> " . json_encode($request->all()));

            $response = $this->fel_token_repo->authenticateClient($request->all());

            \Log::debug("Response autenticación " . $response['expires_in']);

            $this->fel_token_repo->save($request->all(), $response);

            return redirect()->route('admin.restaurants.edit', ['restaurant' => $request->restorant_id])->withStatus(__('Se guardó correctamente los credenciales.'));

        }catch(Exception $ex) {

            \Log::debug("Error al guardar las credenciales " . $ex->getMessage());
            return redirect()->route('admin.restaurants.edit', ['restaurant' => $request->restorant_id])->withError( $ex->getMessage());

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
        //
    }

    /**
     * Update the order item count
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $token_id)
    {
        try{

            $fel_token = FelToken::where('id', $token_id)->first();

            if( empty($fel_token) ){
                throw new Exception("No se encontró un registro de Token");
            }

            if( $request->client_id != $fel_token->client_id || $request->client_secret != $fel_token->client_secret || $request->host != $fel_token->host ) {
                
                $response = $this->fel_token_repo->authenticateClient($request->all());

                $this->fel_token_repo->update($fel_token, $request->all(), $response);

            }

            return redirect()->route('admin.restaurants.edit', ['restaurant' => $request->restorant_id])->withStatus(__('Se actualizó correctamente los credenciales.'));

        } catch(Exception $ex){

            \Log::debug("Error al guardar las credenciales " . $ex->getMessage());
            return redirect()->route('admin.restaurants.edit', ['restaurant' => $request->restorant_id])->withError($ex->getMessage());

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
