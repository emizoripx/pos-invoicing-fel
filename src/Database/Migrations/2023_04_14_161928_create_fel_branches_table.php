<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFelBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fel_branches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('restorant_id')->unsigned();
            $table->string('codigo_sucursal');
            $table->string('descripcion');
            $table->string('zona');
            $table->timestamps();

            $table->unique(['restorant_id', 'codigo_sucursal']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fel_branches');
    }
}
