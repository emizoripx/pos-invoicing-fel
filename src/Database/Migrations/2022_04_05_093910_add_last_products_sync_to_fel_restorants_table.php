<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastProductsSyncToFelRestorantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fel_restorants', function (Blueprint $table) {
            $table->dateTime('last_products_sync')->nullable()->after('is_unipersonal');
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
            $table->dropColumn('last_products_sync');
        });
    }
}
