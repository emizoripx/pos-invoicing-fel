<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFelInvoicesAuxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fel_invoices_aux', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('restorant_id');
            $table->bigInteger('user_id');
            $table->bigInteger('file_id');
            $table->integer('numeroFactura');
            $table->dateTime('fechaEmision');
            $table->string('nombreRazonSocial', 300)->nullable();
            $table->integer('codigoTipoDocumentoIdentidad');
            $table->string('numeroDocumento', 20);
            $table->string('complemento', 20)->nullable();
            $table->integer('codigoMetodoPago')->default(1);
            $table->string('usuario', 20);
            $table->decimal('montoTotal', 20, 5);
            $table->string('codigoCliente', 20)->nullable();
            $table->string('telefonoCliente', 20)->nullable();
            $table->string('emailCliente', 100)->nullable();

            $table->string('product_nombre', 300);
            $table->string('product_codigoProducto', 300);
            $table->bigInteger('item_id');
            $table->integer('product_cantidad')->unsigned();
            $table->decimal('product_precioUnitario', 20, 2);
            $table->decimal('product_montoDescuento', 20, 2);

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
        Schema::dropIfExists('fel_invoices_aux');
    }
}
