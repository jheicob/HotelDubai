<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartialRateToHourTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hour_templates', function (Blueprint $table) {
            $table->foreignId('partial_rate_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->bigInteger('shift_system_id')
                ->unsigned()
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hour_templates', function (Blueprint $table) {
            $table->dropForeign(['partial_rate_id']);
            //
        });
    }
}
