<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToFelProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fel_products', function (Blueprint $table) {
            $table->string('codigoProductoSin', 100)->after('codigoProducto');
            $table->string('codigoActividadEconomica', 100)->after('codigoProductoSin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fel_products', function (Blueprint $table) {
            $table->dropColumn('codigoProductoSin');
            $table->dropColumn('codigoActividadEconomica');
        });
    }
}
