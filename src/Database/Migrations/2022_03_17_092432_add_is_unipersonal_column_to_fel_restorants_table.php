<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsUnipersonalColumnToFelRestorantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fel_restorants', function (Blueprint $table) {
            $table->boolean('is_unipersonal')->default(false)->after('whatsapp_message_limit');
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
            $table->dropColumn('is_unipersonal');
        });
    }
}
