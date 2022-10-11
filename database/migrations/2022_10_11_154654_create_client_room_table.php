<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_room', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('room_id');
            $table->dateTime('date_in');
            $table->dateTime('date_out');
            $table->string('partial_min');
            $table->float('rate');
            $table->string('observation');
            $table->integer('quantity_partial');
            $table->string('time_additional')->comment('format: H:i');
            $table->float('price_additional');
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
        Schema::dropIfExists('client_room');
    }
}
