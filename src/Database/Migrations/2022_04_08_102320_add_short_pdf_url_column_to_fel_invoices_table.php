<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShortPdfUrlColumnToFelInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fel_invoices', function (Blueprint $table) {
            $table->string('short_pdf_url', 100)->nullable()->after('url_pdf');
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
            $table->dropColumn('short_pdf_url');
        });
    }
}
