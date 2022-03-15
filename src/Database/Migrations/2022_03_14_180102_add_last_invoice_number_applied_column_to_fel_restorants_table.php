<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastInvoiceNumberAppliedColumnToFelRestorantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fel_restorants', function (Blueprint $table) {
            $table->integer('last_invoice_number_applied')->unsigned()->nullable()->default(0)->after('settings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fel_restorants', function (Blueprint $table) {
            $table->dropColumn('last_invoice_number_applied');
        });
    }
}
