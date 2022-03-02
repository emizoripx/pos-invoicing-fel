<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => "\EmizorIpx\PosInvoicingFel\Http\Controllers\Api", 'prefix' => 'posfel/v1', 'middleware' => 'web'], function () {

    Route::post("emit/{order_id}", "FelInvoiceController@emit")->name('posfel.emit');
    Route::delete("revocate/{order_id}", "FelInvoiceController@revocate")->name('posfel.revocate');

    Route::get("invoice/{order_id}", "FelInvoiceController@show")->name('posfel.show');


    Route::get('{type_parametric}', 'ParametricController@get' )->name('posfel.parametrics'); // TYPE PARAMETRIC[revocation-reason - units - payments-methods - payments-methods]
});
