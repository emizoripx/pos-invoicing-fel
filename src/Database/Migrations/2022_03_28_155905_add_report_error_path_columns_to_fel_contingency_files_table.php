<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReportErrorPathColumnsToFelContingencyFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fel_contingency_files', function (Blueprint $table) {
            $table->string('error_report_path', 500)->nullable()->after('errors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fel_contingency_files', function (Blueprint $table) {
            $table->dropColumn('error_report_path');
        });
    }
}
