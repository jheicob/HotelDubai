<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableObservationToClientRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_room', function (Blueprint $table) {
            $table->string('observation')->nullable()->change();
            $table->string('time_additional')->nullable()->comment('format: H:i')->change();
            $table->float('price_additional')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_room', function (Blueprint $table) {
            //
        });
    }
}
