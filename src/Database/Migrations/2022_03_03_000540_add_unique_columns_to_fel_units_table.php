<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueColumnsToFelUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fel_units', function (Blueprint $table) {
            $table->unique('codigo')->change();
        });

        Schema::table('fel_revocation_reasons', function (Blueprint $table) {
            $table->unique('codigo')->change();
        });

        Schema::table('fel_payment_methods', function (Blueprint $table) {
            $table->unique('codigo')->change();
        });

        Schema::table('fel_identity_document_types', function (Blueprint $table) {
            $table->unique('codigo')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fel_units', function (Blueprint $table) {
            $table->dropUnique('codigo');
        });

        Schema::table('fel_revocation_reasons', function (Blueprint $table) {
            $table->dropUnique('codigo');
        });
        
        Schema::table('fel_payment_methods', function (Blueprint $table) {
            $table->dropUnique('codigo');
        });

        Schema::table('fel_identity_document_types', function (Blueprint $table) {
            $table->dropUnique('codigo');
        });
    }
}
