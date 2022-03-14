<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFelRestorantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fel_restorants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('restorant_id')->unsigned()->unique();
            $table->boolean('enabled_whatsapp_send')->default(false);
            $table->boolean('enabled_whatsapp_auto_send')->default(false);
            $table->json('settings')->nullable();
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
        Schema::dropIfExists('fel_restorants');
    }
}
