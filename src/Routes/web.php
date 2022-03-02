<?php

use EmizorIpx\PosInvoicingFel\Http\Controllers\FelInvoiceController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => "\EmizorIpx\PosInvoicingFel\Http\Controllers", 'prefix' => 'posfel', 'middleware' => 'web'], function () {

    Route::resource('invoices', 'FelInvoiceController');

});
