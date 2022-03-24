<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFelCafcCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fel_cafc_codes', function (Blueprint $table) {
            $table->id();
            $table->string('cafc', 100);
            $table->string('description', 100);
            $table->bigInteger('restorant_id')->unsigned();
            $table->string('from_invoice_number', 100);
            $table->string('to_invoice_number', 100);
            $table->integer('last_number_applied')->unsigned()->nullable();
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
        Schema::dropIfExists('fel_cafc_codes');
    }
}
