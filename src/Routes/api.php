<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => "\EmizorIpx\PosInvoicingFel\Http\Controllers\Api", 'prefix' => 'posfel/v1', 'middleware' => 'web'], function () {

    Route::post("emit/{order_id}", "FelInvoiceController@emit")->name('posfel.emit');
    Route::delete("revocate/{order_id}", "FelInvoiceController@revocate")->name('posfel.revocate');

    Route::get("invoice/{order_id}", "FelInvoiceController@show")->name('posfel.show');

    Route::get("invoice/state/{invoice_id}", "FelInvoiceController@validateState")->name('posfel.validatestate');

    Route::post('whatsapp-send/{invoice_id}', 'FelInvoiceWhatsappMessageController@send')->name('posfel.whatsapp.send');

    Route::get('validate/nit', 'FelInvoiceController@validateNIT')->name('posfel.validate-nit');
    
    Route::get('{type_parametric}', 'ParametricController@get' )->name('posfel.parametrics'); // TYPE PARAMETRIC[revocation-reason - units - payments-methods - payments-methods]

    Route::get('sync-products/{restorant_id}', 'ParametricController@syncProducts' )->name('posfel.parametrics-sync'); 

});
