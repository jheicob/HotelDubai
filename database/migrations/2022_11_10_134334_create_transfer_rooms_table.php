<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_origin')->constrained('rooms');
            $table->foreignId('room_destiny')->constrained('rooms');
            $table->enum('motive', ['Reparación', 'Inconformidad']);
            $table->string('observation');
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
        Schema::dropIfExists('transfer_rooms');
    }
}
