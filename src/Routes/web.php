<?php

use EmizorIpx\PosInvoicingFel\Http\Controllers\FelInvoiceController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => "\EmizorIpx\PosInvoicingFel\Http\Controllers", 'prefix' => 'posfel', 'middleware' => 'web'], function () {

    Route::resource('invoices', 'FelInvoiceController');

    Route::resource('contingency', 'FelContingencyFileController');

    Route::resource('cafc', 'FelCafcCodeController');

    Route::get('contingency/download-report/{id}', 'FelContingencyFileController@downloadReport')->name('contingency.download_report');

    Route::get('products/export/{id_restorant}', 'FelProductoController@export')->name('products.export');

    Route::resource('integration', 'FelTokenController');

    Route::put('settings/{restorant_id}', 'FelRestorantController@updateSettings')->name('felrestorant.updatesettings');

});
