<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartialRateToDayTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('day_templates', function (Blueprint $table) {
            $table->foreignId('partial_rate_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('day_templates', function (Blueprint $table) {
            $table->dropForeign(['partial_rate_id']);
            //
        });
    }
}
