<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reception', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id');
            $table->foreignId('client_id');
            $table->dateTime('date_in');
            $table->dateTime('date_out');
            $table->boolean('invoiced');
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
        Schema::dropIfExists('reception');
    }
}
