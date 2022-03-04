<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFelSinProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fel_sin_products', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30);
            $table->string('codigoActividad', 30);
            $table->string('descripcion', 1200);
            $table->bigInteger('restorant_id')->unsigned();
            $table->unique(['codigo', 'codigoActividad', 'restorant_id']);
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
        Schema::dropIfExists('fel_sin_products');
    }
}
