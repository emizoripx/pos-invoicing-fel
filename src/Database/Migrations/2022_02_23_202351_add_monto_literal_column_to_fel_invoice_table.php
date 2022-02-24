<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMontoLiteralColumnToFelInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fel_invoices', function (Blueprint $table) {
            $table->string('montoLiteral', 900)->nullable()->after('montoTotal');
            $table->decimal('descuentoAdicional', 20, 5)->nullable()->after('montoLiteral');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fel_invoice', function (Blueprint $table) {
            $table->dropColumn('montoLiteral');
            $table->dropColumn('descuentoAdicional');
        });
    }
}
