<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPdfUrlColumnToFelInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fel_invoices', function (Blueprint $table) {
            $table->string('url_pdf', 500)->nullable()->after('url_sin');
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
            $table->dropColumn('url_pdf');
        });
    }
}
