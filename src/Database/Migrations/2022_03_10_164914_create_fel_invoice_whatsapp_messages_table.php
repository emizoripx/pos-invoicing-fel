<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFelInvoiceWhatsappMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fel_invoice_whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id')->unsigned();
            $table->bigInteger('restorant_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('client_name', 300)->nullable();
            $table->string('message_key', 300)->nullable()->unique();
            $table->boolean('is_send')->default(false);
            $table->string('message_error', 500)->nullable();
            $table->string('message_description', 600)->nullable();
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
        Schema::dropIfExists('fel_invoice_whatsapp_messages');
    }
}
