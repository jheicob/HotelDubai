<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('room_status_id')->unsigned();
            $table->foreignId('partial_template_id');
            $table->foreignId('theme_type_id');
            $table->string('description');

            $table->foreign('room_status_id')
                ->on('room_statuses')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('restrict');



            $table->softDeletes();
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
        Schema::dropIfExists('rooms');
    }
}
