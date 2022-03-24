<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFelContingencyFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fel_contingency_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('restorant_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('cafc_id')->unsigned();
            $table->string('file_name', 200);
            $table->string('file_path', 500);
            $table->string('file_content_type', 500);
            $table->string('file_size_kb', 500);
            $table->string('state', 100)->nullable();
            $table->json('errors')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fel_contingency_files');
    }
}
