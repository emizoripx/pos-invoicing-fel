<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFelInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fel_invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('restorant_id')->unsigned();
            $table->bigInteger('order_id')->unsigned();
            $table->integer('numeroFactura')->unsigned();
            $table->string('cuf', 200);
            $table->string('fechaEmision');
            $table->string('nombreRazonSocial', 500);
            $table->integer('codigoTipoDocumentoIdentidad')->unsigned();
            $table->string('numeroDocumento');
            $table->string('complemento')->nullable();
            $table->string('codigoCliente');
            $table->string('emailCliente')->nullable();
            $table->string('telefonoCliente')->nullable();
            $table->integer('codigoSucursal')->unsigned()->default(0);
            $table->string('direccion', 500)->nullable();
            $table->string('leyenda', 500)->nullable();
            $table->string('usuario');
            $table->decimal('montoTotal', 20, 5);
            $table->decimal('montoTotalSujetoIva', 20, 5);
            $table->json('detalles');
            $table->string('razonSocialEmisor', 500)->nullable();
            $table->string('nitEmisor')->nullable();
            $table->string('telefonoEmisor')->nullable();
            $table->string('municipio')->nullable();
            $table->integer('codigoMetodoPago')->unsigned()->nullable();
            $table->integer('codigoEstado')->nullable();
            $table->string('estado')->nullable();
            $table->json('errores')->nullable();
            $table->integer('revocation_reason_code')->unsigned()->nullable();
            $table->string('type_invoice', 100)->nullable();
            $table->string('url_sin', 300)->nullable();
            $table->string('tipoEmision', 300)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fel_invoices');
    }
}
