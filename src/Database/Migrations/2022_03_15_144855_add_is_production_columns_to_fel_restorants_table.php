<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsProductionColumnsToFelRestorantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fel_restorants', function (Blueprint $table) {
            $table->boolean('has_limit')->default(true)->after('last_invoice_number_applied');
            $table->integer('whatsapp_message_limit')->unsigned()->default(5)->after('has_limit');
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
            $table->dropColumn('has_limit');
            $table->dropColumn('whatsapp_message_limit');
        });
    }
}
