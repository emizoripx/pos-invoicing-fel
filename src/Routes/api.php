<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => "\EmizorIpx\PosInvoicingFel\Http\Controllers", 'prefix' => 'posfel', 'middleware' => 'web'], function () {
    Route::get("invoicing", "MainController@index");
    Route::post("emit/{order_id}", "FelInvoiceController@emit")->name('posfel.emit');
    Route::get("invoice/{order_id}", "FelInvoiceController@show")->name('posfel.show');
});
