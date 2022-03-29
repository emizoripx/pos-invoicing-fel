<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCafcColumnToFelInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fel_invoices', function (Blueprint $table) {
            $table->string('cafc', 100)->nullable()->after('tipoEmision');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fel_invoices', function (Blueprint $table) {
            $table->dropColumn('cafc');
        });
    }
}
